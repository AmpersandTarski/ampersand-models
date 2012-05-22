{-# OPTIONS_GHC -Wall #-}
module NameMapper where

import DatabaseDesign.Ampersand
import DatabaseDesign.Ampersand.Core.AbstractSyntaxTree
import Data.String.Utils

import Control.Monad
import System.Exit
import System.FilePath
import Prelude hiding (putStr,readFile,writeFile)
import qualified DatabaseDesign.Ampersand.Core.Poset.Internal


main :: IO ()
main =
 do { opts <- getOptions
    ; if showVersion opts || showHelp opts
        then mapM_ putStr (helpNVersionTexts ampersandVersionStr opts)
        else do { actx <- parseAndTypeCheck opts
                ; generate opts actx
                }
    }             
  where
      parseAndTypeCheck :: Options -> IO A_Context 
      parseAndTypeCheck opts =
       do { verboseLn opts "Start parsing...."
          ; pCtx <- parseContext opts (fileName opts)
          ; case pCtx of
              Left msg ->
               do { Prelude.putStrLn $ "Parse error:"
                  ; Prelude.putStrLn $ show msg
                  ; exitWith $ ExitFailure 10 
                  }
              Right pctx -> 
               do { pPops <- case importfile opts of
                               [] -> return []
                               fn -> do { popsText <- readFile fn
                                        ; parsePopulations popsText opts fn
                                        }
                  ; verboseLn opts "Type checking..."
                  ; let (actx,err) = typeCheck pctx pPops
                  ; if nocxe err 
                    then return actx
                    else do { Prelude.putStrLn $ "Type error:"
                            ; Prelude.putStrLn $ show err
                            ; exitWith $ ExitFailure 20
                            }
                  }
          }



generate :: Options -> A_Context -> IO ()
generate opts c = 
 do { verboseLn opts "Generating..."
    ; cptmap <- readcptmap
    ; relmap <- readrelmap
    ; strmap <- readstrmap
    ; writeFile outputFile (f strmap (showADL (mapname c cptmap relmap))) 
    ; verboseLn opts $ ".adl-file written to " ++ outputFile ++ "."
    }
 where
 f [] x = x
 f ((old,new):ons) x = f ons (replace old new x)
 outputFile = combine (dirOutput opts) (outputfile opts)
 readcptmap ::  IO [(String,String)]
 readcptmap 
  = do { str<-readFile fp
       ; return [(head xs,last xs) | line<-splitWs str, let xs = split ";" line, length xs==2]
       }
  where fp = combine (dirOutput opts) "cptmap.csv"
 readrelmap :: IO [(String,String,String,String)] 
 readrelmap
  = do { str<-readFile fp
       ; return [(head xs,head(tail xs),head(tail (tail xs)),last xs) | line<-splitWs str, let xs = split ";" line, length xs==4]
       }
  where fp = combine (dirOutput opts) "relmap.csv"
 readstrmap ::  IO [(String,String)]
 readstrmap 
  = do { str<-readFile fp
       ; return [(head xs,last xs) | line<-split "\r\n" str, let xs = split ";" line, length xs==2]
       }
  where fp = combine (dirOutput opts) "strmap.csv"

class Map a where
  mapname :: a -> [(String,String)] -> [(String,String,String,String)] -> a

instance Map a => Map [a] where
  mapname xs m n = [mapname x m n | x<-xs]

instance Map A_Context where
  mapname x m n 
      = x{ ctxpats = mapname (ctxpats x) m n
         , ctxprocs = mapname (ctxprocs x) m n
         , ctxrs = mapname (ctxrs x) m n
         , ctxds= mapname (ctxds x) m n
         , ctxcds  = [] --INCLUDE new definitions
         , ctxks   = mapname (ctxks x) m n
         , ctxgs   = mapname (ctxgs x) m n
         , ctxifcs = [] --not relevant
         , ctxps = [] --INCLUDE new purposes
         , ctxsql = [] --not relevant
         , ctxphp = [] --not relevant
         , ctxmetas = [] --not relevant
         }   
instance Map Pattern where
  mapname x m n
        = x{ ptrls = mapname (ptrls x) m n
           , ptgns = mapname (ptgns x) m n
           , ptdcs = mapname (ptdcs x) m n
           , ptkds = mapname (ptkds x) m n
           , ptxps = [] --INCLUDE new purposes
           }
instance Map Process where
  mapname x m n = x { prcRules = mapname (prcRules x) m n
                    , prcGens  = mapname (prcGens x) m n
                    , prcDcls  = mapname (prcDcls x) m n
                    , prcRRuls = [(r,mapname x m n) | (r,x)<-prcRRuls x]
                    , prcRRels = [(r,mapname x m n) | (r,x)<-prcRRels x]
                    , prcKds   = mapname (prcKds x) m n
                    , prcXps   = [] --INCLUDE new purposes
                    }
instance Map Rule where
  mapname x m n
     = x{ rrexp  = mapname (rrexp x) m n
        , rrviol = (case rrviol x of
                       Nothing->Nothing
                       Just (PairView pvs) -> Just (PairView [case pv of PairViewExp st exp -> PairViewExp st (mapname exp m n) ; _->pv | pv<-pvs]))
        , rrtyp = mapname (rrtyp x) m n
        , rrdcl = (case rrdcl x of
                       Nothing->Nothing
                       Just (p,d) -> Just (p,mapname d m n))
        , srrel = mapname (srrel x) m n
        }
instance Map Declaration where
  mapname x@(Sgn{}) m n 
   = x{ decnm = if null rnms then decnm x else concat rnms
      , decsgn  = mapname (decsgn x) m n
      , decConceptDef = Nothing
      }
      where rnms = [newr | (r,s,t,newr)<-n, r==decnm x, null s||s==name(source x), null t||t==name(target x)] 
  mapname x@(Isn{}) m n = x{detyp = mapname (detyp x) m n}
  mapname x@(Iscompl{}) m n = x{detyp = mapname (detyp x) m n}
  mapname x@(Vs{}) m n = x{decsgn = mapname (decsgn x) m n}
instance Map KeyDef where
  mapname x m n
             = x { kdcpt  = mapname (kdcpt x) m n
                 , kdats = [case k of KeyExp o -> KeyExp (o{objctx=mapname (objctx o) m n});_->k | k<-kdats x]
                 }
instance Map A_Gen where
  mapname x m n 
              = x{ gengen = mapname (gengen x) m n
                 , genspc = mapname (genspc x) m n
                 }
instance Map Relation where
  mapname x@(Rel{}) m n 
   = x{ relnm  = if null rnms then relnm x else concat rnms
      , relsgn = mapname (relsgn x) m n
      , reldcl = mapname (reldcl x) m n
      }
      where rnms = [newr | (r,s,t,newr)<-n, r==relnm x, null s||s==name(source(reldcl x)), null t||t==name(target(reldcl x))]
  mapname x@(I{}) m n = x{ rel1typ = mapname (rel1typ x) m n}
  mapname x@(V{}) m n = x{ reltyp = mapname (reltyp x) m n}
  mapname x@(Mp1{}) m n = x{ rel1typ = mapname (rel1typ x) m n}
instance Map Sign where
  mapname (Sign x y) m n = Sign (mapname x m n) (mapname y m n)
instance Map A_Concept where
  mapname ONE _ _ = ONE
  mapname x m n = x { cptnm = if null cnms then cptnm x else concat cnms
                    , cptdf=[] --INCLUDE new definitions
                    , cptgE=((\_ _-> DatabaseDesign.Ampersand.Core.Poset.Internal.EQ),[]) --assume type checker is bug free
                    }
                    where cnms = [newc | (c,newc)<-m, c==name x]

instance Map Expression where
  mapname x m n = subs x
     where
       subs (EEqu (l,r)) = EEqu (subs l,subs r)
       subs (EImp (l,r)) = EImp (subs l,subs r)
       subs (EIsc es)    = EIsc (map subs es)
       subs (EUni es)    = EUni (map subs es)
       subs (EDif (l,r)) = EDif (subs l,subs r)
       subs (ELrs (l,r)) = ELrs (subs l,subs r)
       subs (ERrs (l,r)) = ERrs (subs l,subs r)
       subs (ECps es)    = ECps (map subs es)
       subs (ERad es)    = ERad (map subs es)
       subs (EPrd es)    = EPrd (map subs es)
       subs (EKl0 e)     = EKl0 (subs e)
       subs (EKl1 e)     = EKl1 (subs e)
       subs (EFlp e)     = EFlp (subs e)
       subs (ECpl e)     = ECpl (subs e)
       subs (EBrk e)     = EBrk (subs e)
       subs (ETyp e sgn) = ETyp (subs e) (mapname sgn m n)
       subs (ERel r)     = ERel (mapname r m n)


