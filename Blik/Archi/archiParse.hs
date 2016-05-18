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

   data ArchiRepo = ArchiRepo
     { archRepoName   :: String
     , archRepoId     :: String
     , archFolders    :: [Folder]
     , archProperties :: [Prop]
     } deriving (Show, Eq)
 
   data Folder = Folder
     { fldName        :: String
     , fldId          :: String
     , fldType        :: String
     , fldElems       :: [Element]
     , fldFolders     :: [Folder]
     } deriving (Show, Eq)

   data Child = Child
     { chldType       :: String
     , chldId         :: String
     , chldAlgn       :: String
     , chldFCol       :: String
     , chldElem       :: String
     , trgtConn       :: String
     , bound          :: Bound
     , srcConns       :: [SourceConnection]
     , childs         :: [Child]
     } deriving (Show, Eq)

   data Relation = Relation
     { relType        :: String
     , relHref        :: String
     } deriving (Show, Eq)

   data Bound = Bound
     { bnd_x          :: String
     , bnd_y          :: String
     , bnd_width      :: String
     , bnd_height     :: String
     } deriving (Show, Eq)

   data SourceConnection = SrcConn
     { sConType       :: String
     , sConId         :: String
     , sConSrc        :: String
     , sConTgt        :: String
     , sConRel        :: Relation
     } deriving (Show, Eq)

   data Prop = Prop
     { archPropKey    :: String
     , archPropVal    :: String
     } deriving (Show, Eq)

   data Element = Element
     { elemType       :: String
     , elemId         :: String
     , elemName       :: String
     , elemDocu       :: String
     , elChilds       :: [Child]
     , elProps        :: [Prop]
     } deriving (Show, Eq)


   main = do archiRepo <- runX (processStraight "CA repository.archimate")
             print archiRepo

-- processStraight shows how to process an Archimate file into an HTML-list of elements without defining an intermediary data structure.
   processStraight infile
    = readDocument [ withRemoveWS  yes        -- purge redundant white spaces
                   , withCheckNamespaces yes  -- propagates name spaces into QNames
                   , withTrace 0]             -- if >0 gives trace messages.
                   infile
      >>>
      analArchiRepo
       where
        analArchiRepo :: ArrowXml a => a XmlTree ArchiRepo
        analArchiRepo
          = atTag "archimate:ArchimateModel" >>>
            proc l -> do repoNm    <- getAttrValue "name"               -< l
                         repoId    <- getAttrValue "id"                 -< l
                         folders   <- listA (getChildren >>> getFolder) -< l
                         props     <- listA (getChildren >>> getProp)   -< l
                         returnA -< ArchiRepo { archRepoName   = repoNm
                                              , archRepoId     = repoId
                                              , archFolders    = folders
                                              , archProperties = props
                                              }

        getElement :: ArrowXml a => a XmlTree Element
        getElement = atTag "elements" >>>
            proc l -> do elemType  <- getAttrValue "xsi:type"           -< l
                         elemId    <- getAttrValue "id"                 -< l
                         elemName  <- getAttrValue "name"               -< l
                         elemDocu  <- getAttrValue "documentation"      -< l
                         childs    <- listA (getChildren >>> getChild)  -< l
                         props     <- listA (getChildren >>> getProp)   -< l
                         returnA   -< Element  { elemType = elemType
                                               , elemId   = elemId
                                               , elemName = elemName
                                               , elemDocu = elemDocu
                                               , elChilds = childs
                                               , elProps  = props
                                               }

-- <relationship xsi:type="archimate:TriggeringRelationship" href="../../../Desktop/NVWA%20Archi/model/folder.xml#4a03eb19"/>
        getRelation :: ArrowXml a => a XmlTree Relation
        getRelation = isElem >>> hasName "relationship" >>>
            proc l -> do relType    <- getAttrValue "xsi:type"           -< l
                         relHref    <- getAttrValue "href"              -< l
                         returnA    -< Relation{ relType = relType
                                               , relHref = relHref
                                               }

        getBound :: ArrowXml a => a XmlTree Bound
        getBound = isElem >>> hasName "bounds" >>>
            proc l -> do bnd_x      <- getAttrValue "x"                 -< l
                         bnd_y      <- getAttrValue "y"                 -< l
                         bnd_width  <- getAttrValue "width"             -< l
                         bnd_height <- getAttrValue "height"            -< l
                         returnA    -< Bound   { bnd_x      = bnd_x
                                               , bnd_y      = bnd_y
                                               , bnd_width  = bnd_width
                                               , bnd_height = bnd_height
                                               }

        getSrcConn :: ArrowXml a => a XmlTree SourceConnection
        getSrcConn = isElem >>> hasName "sourceConnections" >>>
            proc l -> do sConType   <- getAttrValue "xsi:type"          -< l
                         sConId     <- getAttrValue "id"                -< l
                         sConSrc    <- getAttrValue "source"            -< l
                         sConTgt    <- getAttrValue "target"            -< l
                         sConRel    <- getChildren >>> getRelation      -< l
--                         bendPts   <- listA (getChildren >>> getChild)   -< l
                         returnA    -< SrcConn { sConType = sConType
                                               , sConId   = sConId
                                               , sConSrc  = sConSrc
                                               , sConTgt  = sConTgt
                                               , sConRel  = sConRel
                                               }

        getChild
         = atTag "children" >>>
            proc l -> do chldType <- getAttrValue "xsi:type"            -< l
                         chldId   <- getAttrValue "id"                  -< l
                         chldName <- getAttrValue "name"                -< l
                         chldFCol <- getAttrValue "fillColor"           -< l
                         chldAlgn <- getAttrValue "textAlignment"       -< l
                         chldElem <- getAttrValue "archimateElement"    -< l
                         trgtConn <- getAttrValue "targetConnections"   -< l
                         bound    <- getChildren >>> getBound           -< l
                         srcConns <- listA (getChildren >>> getSrcConn) -< l
                         childs   <- listA (getChildren >>> getChild)   -< l
                         returnA  -< Child { chldType = chldType
                                           , chldId   = chldId
                                           , chldAlgn = chldAlgn
                                           , chldFCol = chldFCol
                                           , chldElem = chldElem
                                           , trgtConn = trgtConn
                                           , bound    = bound
                                           , srcConns = srcConns
                                           , childs   = childs
                                           }

        getFolder :: ArrowXml a => a XmlTree Folder
        getFolder
         = isElem >>> hasName "folders" >>>
            proc l -> do fldNm   <- getAttrValue "name"                 -< l
                         fldId   <- getAttrValue "id"                   -< l
                         fldType <- getAttrValue "type"                 -< l
                         elems   <- listA (getChildren >>> getElement)  -< l
                         subFlds <- listA (getChildren >>> getFolder)   -< l
                         returnA -< Folder { fldName    = fldNm
                                           , fldId      = fldId
                                           , fldType    = fldType
                                           , fldElems   = elems
                                           , fldFolders = subFlds
                                           }

        getProp :: ArrowXml a => a XmlTree Prop
        getProp = isElem >>> hasName "properties" >>>
            proc l -> do propKey <- getAttrValue "key"   -< l
                         propVal <- getAttrValue "value" -< l
                         returnA -< Prop { archPropKey = propKey
                                         , archPropVal = propVal
                                         }

-- Auxiliaries

   atTag :: ArrowXml a => String -> a (NTree XNode) XmlTree
   atTag tag = deep (isElem >>> hasName tag)
