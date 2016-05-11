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
     { archRepoName     :: String
     , archRepoId       :: String
     , archFolders      :: [Folder]
     , archProperties   :: [Prop]
     } deriving (Show, Eq)
 
   data Folder = Folder
     { fldName    :: String
     , fldId      :: String
     , fldType    :: String
     , fldElems   :: [Element]
     , fldFolders :: [Folder]
     } deriving (Show, Eq)

   data Prop = Prop
     { archPropKey     :: String
     , archPropVal     :: String
     } deriving (Show, Eq)

   data Element = Element
     { elemType :: String
     , elemId   :: String
     , elemName :: String
     , elemDocu :: String
     , elProps  :: [Prop]
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
            proc l -> do repoNm    <- getAttrValue "name"                 -< l
                         repoId    <- getAttrValue "id"                   -< l
                         folders   <- listA getFolder                     -< l
                         props     <- listA (getChildren >>> getProps)    -< l
                         returnA -< ArchiRepo { archRepoName     = repoNm
                                              , archRepoId       = repoId
                                              , archFolders      = folders
                                              , archProperties   = props
                                              }

        getElement :: ArrowXml a => a XmlTree Element
        getElement = atTag "elements" >>>
            proc l -> do elemType  <- getAttrValue "xsi:type"          -< l
                         elemId    <- getAttrValue "id"                -< l
                         elemName  <- getAttrValue "name"              -< l
                         elemDocu  <- getAttrValue "documentation"     -< l
                         props     <- listA (getChildren >>> getProps) -< l
                         returnA   -< Element  { elemType = elemType
                                               , elemId   = elemId
                                               , elemName = elemName
                                               , elemDocu = elemDocu
                                               , elProps  = props
                                               }

        getFolder :: ArrowXml a => a XmlTree Folder
        getFolder
         = atTag "folders" >>>
            proc l -> do fldNm   <- getAttrValue "name"                -< l
                         fldId   <- getAttrValue "id"                  -< l
                         fldType <- getAttrValue "type"                -< l
                         elems   <- listA (getChildren >>> getElement) -< l
                         subFlds <- listA (getChildren >>> getFolder)  -< l
                         returnA -< Folder { fldName    = fldNm
                                           , fldId      = fldId
                                           , fldType    = fldType
                                           , fldElems   = elems
                                           , fldFolders = subFlds
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
