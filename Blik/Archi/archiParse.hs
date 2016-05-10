{-# LANGUAGE Arrows, NoMonomorphismRestriction #-}
module Main where
   import System.IO
   import System.Environment
   import System.Exit
   import System.Console.GetOpt
   import Data.Maybe
   import Data.Tree.NTree.TypeDefs
   import Text.XML.HXT.Core
    
   -- This example demonstrates a more complex XML parse,
   -- involving multiple levels, attributes, inner lists,
   -- and dealing with optional data.

-- I'm trying to derive an Archimate-data structure (called ArchiRepo) from an Archi-XML-file. I also want transormers to and from an ArchiRepo and the Archi-XML

   -- <archimate:ArchimateModel xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:archimate="http://www.archimatetool.com/archimate" name="NVWA: CA Repository GIT" id="d801043f" purpose="" version="3.1.1">
   data ArchiRepo = ArchiRepo
     { archRepoName     :: String
     , archRepoId       :: String
--     , archProcesFlows  :: [ProcesFlow]
--     , archKanalen      :: [Element]
--     , archProducten    :: [Element]
--     , archBdrFuncties  :: [Element]
--     , archRollen       :: [Element]
--     , archBedrObjecten :: [Element]
--     , archBedrRegels   :: [Element]
--     , archStakeholders :: [Element]
--     , archBedrEvents   :: [Element]
     , archInfSystemen  :: [Element]
     , archApplicaties  :: [Element]
     , archFolders      :: [Folder]
     , archProperties   :: [Prop]
--     , archElements     :: [Element]  -- other elements, not in a specific folder.
     } deriving (Show, Eq)
 
   data Folder = Folder
     { archFolderName    :: String
     , archFolderId      :: String
     , archFolderType    :: String
     } deriving (Show, Eq)

   data Prop = Prop
     { archPropKey     :: String
     , archPropVal     :: String
     } deriving (Show, Eq)

   data ProcesFlow = ProcesFlow
     { pfName  :: String
     , pfId    :: String
     , pfProcs :: [Element]
     } deriving (Show, Eq)

   data Element = Element
     { elemType :: String
     , elemId   :: String
     , elemName :: String
     , elemDocu :: String
     , elProps  :: [Prop]
     } deriving (Show, Eq)


   main = do archiRepo <- runX (processStraight "CA repository.archimate" "output.html")
             print archiRepo

-- processStraight shows how to process an Archimate file into an HTML-list of elements without defining an intermediary data structure.
   processStraight infile outfile
    = readDocument [ withRemoveWS  yes        -- purge redundant white spaces
                   , withCheckNamespaces yes  -- propagates name spaces into QNames
                   , withTrace 0]             -- if >0 gives trace messages.
                   infile
      >>>
      analArchiRepo
       where
  -- Example:  <elements xsi:type="archimate:AggregationRelationship" id="ffc39a03" source="7214768a" target="77d04ae6"/>
        analArchiRepo :: ArrowXml a => a XmlTree ArchiRepo
        analArchiRepo
          = atTag "archimate:ArchimateModel" >>>
            proc l -> do repoNm    <- getAttrValue "name"                 -< l
                         repoId    <- getAttrValue "id"                   -< l
--                         procFlows <- listA getProcesFlow                 -< l
--                         kanalen   <- listA (getElems ["Business", "Kanalen"])          -< l
--                         producten <- listA (getElems ["Business", "Producten"])        -< l
--                         bedrFies  <- listA (getElems ["Business", "Bedrijfsfuncties"]) -< l
--                         rollen    <- listA (getElems ["Business", "Rollen"])           -< l
--                         bedrObjs  <- listA (getElems ["Business", "Bedrijfsobjecten"]) -< l
--                         bdrRegels <- listA (getElems ["Business", "Bedrijfsregels"])   -< l
--                         stakehs   <- listA (getElems ["Business", "Stakeholders"])     -< l
--                         events    <- listA (getElems ["Business", "Bedrijfs event"])   -< l
--                         others    <- listA (getElems ["Business"])                     -< l
                         infSyss   <- listA (getElems ["Application", "Informatiesystemen"]) -< l
                         applics   <- listA (getElems ["Application", "Applicaties"])        -< l
                         folders   <- listA getFolder                     -< l
                         props     <- listA (getChildren >>> getProps)    -< l
                         returnA -< ArchiRepo { archRepoName     = repoNm
                                              , archRepoId       = repoId
--                                              , archProcesFlows  = procFlows
--                                              , archKanalen      = kanalen
--                                              , archProducten    = producten
--                                              , archBdrFuncties  = bedrFies 
--                                              , archRollen       = rollen   
--                                              , archBedrObjecten = bedrObjs 
--                                              , archBedrRegels   = bdrRegels
--                                              , archStakeholders = stakehs  
--                                              , archBedrEvents   = events   
                                              , archInfSystemen  = infSyss
                                              , archApplicaties  = applics
                                              , archFolders      = folders
                                              , archProperties   = props
--                                              , archElements     = others
                                              }

        getProcesFlow :: ArrowXml a => a XmlTree ProcesFlow
        getProcesFlow
          = atTag "folders" >>> hasAttrValue "name" (=="Business")    >>> getChildren >>> 
            atTag "folders" >>> hasAttrValue "name" (=="Procesflows") >>> getChildren >>> 
            atTag "folders" >>>
            proc l -> do pfName  <- getAttrValue "name"                            -< l
                         pfId    <- getAttrValue "id"                              -< l
                         pfProcs <- listA (getElement ["Business", "Procesflows"]) -< l
                         returnA -< ProcesFlow { pfName  = pfName
                                               , pfId    = pfId
                                               , pfProcs = pfProcs
                                               }

-- | If `getElems` covers two levels of folders, as in getElems ["Business", "Kanalen"]
--   you get:
--          = atTag "folders" >>> hasAttrValue "name" (=="Business")  >>> getChildren >>> 
--            atTag "folders" >>> hasAttrValue "name" (=="Kanalen")   >>> getElement
        getElems :: ArrowXml a => [String] -> a XmlTree Element
        getElems labels
          = foldr1 f [atTag "folders" >>> hasAttrValue "name" (==label) | label<-labels ] >>> getElement labels
             where x `f` y = x >>> getChildren >>> y

        getElement :: ArrowXml a => [String] -> a XmlTree Element
        getElement labels = atTag "elements" >>>
            proc l -> do elemType  <- getAttrValue "xsi:type"          -< l
                         elemId    <- getAttrValue "id"                -< l
                         elemName  <- getAttrValue "name"              -< l
                         elemDocu  <- getAttrValue "documentation"     -< l
                         props     <- listA (getChildren >>> getProps) -< l
                         returnA   -< Element  { elemType = elemType
                                               , elemId   = elemId
                                               , elemName = elemName
                                               , elemDocu = elemDocu
                                               , elProps  = props++[Prop key val | (key,val)<-zip ["layer","concept"] labels]
                                               }

        getFolder :: ArrowXml a => a XmlTree Folder
        getFolder = atTag "folders" >>>
            proc l -> do fldNm   <- getAttrValue "name" -< l
                         fldId   <- getAttrValue "id"   -< l
                         fldType <- getAttrValue "type" -< l
                         returnA -< Folder { archFolderName = fldNm
                                           , archFolderId   = fldId
                                           , archFolderType = fldType
                                           }

        getProps :: ArrowXml a => a XmlTree Prop
        getProps = isElem >>> hasName "properties" >>>
            proc l -> do propKey <- getAttrValue "key"   -< l
                         propVal <- getAttrValue "value" -< l
                         returnA -< Prop { archPropKey = propKey
                                         , archPropVal = propVal
                                         }

-- Auxiliaries

   atTag :: ArrowXml a => String -> a (NTree XNode) XmlTree
   atTag tag = deep (isElem >>> hasName tag)
