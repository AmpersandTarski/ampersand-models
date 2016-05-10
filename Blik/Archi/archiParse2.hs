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

   -- I'm trying to derive an Archimate-data structure (called ArchiRepo) from an Archi-XML-file. I also want to generate XML-files from a Haskell data structure.

   -- Example: <archimate:ArchimateModel xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:archimate="http://www.archimatetool.com/archimate" name="NVWA: CA Repository GIT" id="d801043f" purpose="" version="3.1.1">
   data ArchiRepo = ArchiRepo
     { archRepoName :: String
     , archRepoId   :: String
     , archElems    :: [(String,String)]
     } deriving (Show, Eq)
 
   archiRepo :: ArchiRepo
   archiRepo = ArchiRepo "NVWA: CA Repository GIT" "d801043f" []

   main = do [rc] <- runX (processStruct "" >>> getErrStatus)
             exitWith ( if rc >= c_err
                        then ExitFailure (-1)
                        else ExitSuccess
                      )

   xmlArchiRepo :: ArrowXml a => ArchiRepo -> a XmlTree XmlTree
   xmlArchiRepo archiRepo
       = root [] [mkelem "archimate:ArchimateModel"
                         [ sattr "xmlns:xsi" "http://www.w3.org/2001/XMLSchema-instance"
                         , sattr "xmlns:archimate" "http://www.archimatetool.com/archimate"
                         , sattr "name" (archRepoName archiRepo)
                         , sattr "id" (archRepoId   archiRepo)
                         ]
                         [ txt "to be done" ]
                 ]

-- processStraight shows how to process an Archimate file into an HTML-list of elements without defining an intermediary data structure.
   processStruct outfile
    = xmlArchiRepo archiRepo
      >>>
      writeDocument [withIndent yes] outfile

-- processStraight shows how to process an Archimate file into an HTML-list of elements without defining an intermediary data structure.
   processStraight infile outfile
    = readDocument [ withRemoveWS  yes        -- purge redundant white spaces
                   , withCheckNamespaces yes  -- propagates name spaces into QNames
                   , withTrace 0]             -- if >0 gives trace messages.
                   infile
      >>>
      elementsTable
      >>>
      writeDocument [withIndent yes] outfile
       where

  -- Example:  <elements xsi:type="archimate:AggregationRelationship" id="ffc39a03" source="7214768a" target="77d04ae6"/>
        elementsTable :: ArrowXml a => a XmlTree XmlTree
        elementsTable
          = root [] [ selem "html"
                            [ selem "head"
                                    [ selem "title" [ txt "Elements in Page" ]
                                    ]
                            , selem "body"
                                    [ selem "h1" [ txt "Elements in Page" ]
                                    , selem "table"
                                            [ atTag "elements"        -- (1)
                                              >>>
                                              genTableRows            -- (2)
                                            ]
                                    ]
                            ]
                    ]

        genTableRows :: ArrowXml a => a XmlTree XmlTree
        genTableRows                    -- (2)
           = selem "tr"
             [ selem "td" [ getAttrValue "xsi:type" >>> mkText ]
               <+>
               selem "td" [ getAttrValue "id"       >>> mkText ]
--               <+>
--               selem "td" [ getAttrValue "source"   >>> mkText ]
--               <+>
--               selem "td" [ getAttrValue "target"   >>> mkText ]
             ]

-- Auxiliaries

   atTag :: ArrowXml a => String -> a (NTree XNode) XmlTree
   atTag tag = deep (isElem >>> hasName tag)
