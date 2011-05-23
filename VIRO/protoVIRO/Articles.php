<?php // generated with ADL vs. 0.8.10-452
/***************************************\
*                                       *
*   Interface V1.3.1                    *
*   (c) Bas Joosten Jun 2005-Aug 2009   *
*                                       *
*   Using interfaceDef                  *
*                                       *
\***************************************/
  require "interfaceDef.inc.php";
  require "Articles.inc.php";
  require "connectToDataBase.inc.php";
  if(isset($_REQUEST['save'])) { // handle ajax save request (do not show the interface)
    // we posted . characters, but something converts them to _ (HTTP 1.1 standard)
    $r=array();
    foreach($_REQUEST as $i=>$v){
      $r[join('.',explode('_',$i))]=$v; //convert _ back to .
    }
    $Articles=array();
    for($i0=0;isset($r['0.'.$i0]);$i0++){
      $Articles[$i0] = array( 'id' => @$r['0.'.$i0.'.0']
                            , 'article' => @$r['0.'.$i0.'.0']
                            );
      $Articles[$i0]['act']=array();
      for($i1=0;isset($r['0.'.$i0.'.1.'.$i1]);$i1++){
        $Articles[$i0]['act'][$i1] = @$r['0.'.$i0.'.1.'.$i1.''];
      }
      $Articles[$i0]['organ']=array();
      for($i1=0;isset($r['0.'.$i0.'.2.'.$i1]);$i1++){
        $Articles[$i0]['organ'][$i1] = @$r['0.'.$i0.'.2.'.$i1.''];
      }
      $Articles[$i0]['verb']=array();
      for($i1=0;isset($r['0.'.$i0.'.3.'.$i1]);$i1++){
        $Articles[$i0]['verb'][$i1] = @$r['0.'.$i0.'.3.'.$i1.''];
      }
      $Articles[$i0]['object type']=array();
      for($i1=0;isset($r['0.'.$i0.'.4.'.$i1]);$i1++){
        $Articles[$i0]['object type'][$i1] = @$r['0.'.$i0.'.4.'.$i1.''];
      }
    }
    $Articles=new Articles($Articles);
    if($Articles->save()!==false) die('ok:'.$_SERVER['PHP_SELF']); else die('');
    exit(); // do not show the interface
  }
  $buttons="";
  if(isset($_REQUEST['edit'])) $edit=true; else $edit=false;
  $Articles=new Articles();
    writeHead("<TITLE>Articles - VIRO - ADL Prototype</TITLE>"
              .($edit?'<SCRIPT type="text/javascript" src="edit.js"></SCRIPT>':'<SCRIPT type="text/javascript" src="navigate.js"></SCRIPT>')."\n" );
    if($edit)
        echo '<FORM name="editForm" action="'
              .$_SERVER['PHP_SELF'].'" method="POST" class="Edit">';
    ?><H1>Articles</H1>
    <DIV class="Floater Articles">
      <DIV class="FloaterHeader">Articles</DIV>
      <DIV class="FloaterContent"><?php
          $Articles = $Articles->get_Articles();
          echo '
          <UL>';
          foreach($Articles as $i0=>$v0){
            echo '
            <LI CLASS="item UI" ID="0.'.$i0.'">';
              if(!$edit){
                echo '
              <A HREF="Article.php?Article='.urlencode($v0['id']).'">';
                echo '<DIV class="GotoArrow">&rarr;</DIV></A>';
              }
              echo '
              <DIV>';
                echo 'article: ';
                echo '<SPAN CLASS="item UIarticle" ID="0.'.$i0.'.0">';
                echo htmlspecialchars($v0['article']);
                echo '</SPAN>';
              echo '</DIV>
              <DIV>';
                echo 'act: ';
                echo '
                <UL>';
                foreach($v0['act'] as $i1=>$act){
                  echo '
                  <LI CLASS="item UIact" ID="0.'.$i0.'.1.'.$i1.'">';
                    echo htmlspecialchars($act);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIact" ID="0.'.$i0.'.1.'.count($v0['act']).'">new act</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'organ: ';
                echo '
                <UL>';
                foreach($v0['organ'] as $i1=>$organ){
                  echo '
                  <LI CLASS="item UIorgan" ID="0.'.$i0.'.2.'.$i1.'">';
                    if(!$edit) echo '
                    <A HREF="Organ.php?Organ='.urlencode($organ).'">'.htmlspecialchars($organ).'</A>';
                    else echo htmlspecialchars($organ);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIorgan" ID="0.'.$i0.'.2.'.count($v0['organ']).'">new organ</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'verb: ';
                echo '
                <UL>';
                foreach($v0['verb'] as $i1=>$verb){
                  echo '
                  <LI CLASS="item UIverb" ID="0.'.$i0.'.3.'.$i1.'">';
                    echo htmlspecialchars($verb);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIverb" ID="0.'.$i0.'.3.'.count($v0['verb']).'">new verb</LI>';
                echo '
                </UL>';
              echo '</DIV>
              <DIV>';
                echo 'object type: ';
                echo '
                <UL>';
                foreach($v0['object type'] as $i1=>$objecttype){
                  echo '
                  <LI CLASS="item UIobjecttype" ID="0.'.$i0.'.4.'.$i1.'">';
                    echo htmlspecialchars($objecttype);
                  echo '</LI>';
                }
                if($edit) echo '
                  <LI CLASS="new UIobjecttype" ID="0.'.$i0.'.4.'.count($v0['object type']).'">new object type</LI>';
                echo '
                </UL>';
              echo '
              </DIV>';
              if($edit) echo '
              <INPUT TYPE="hidden" name="0.'.$i0.'.ID" VALUE="'.$v0['id'].'" />';
            echo '</LI>';
          }
          if($edit) echo '
            <LI CLASS="new UI" ID="0.'.count($Articles).'">new Articles</LI>';
          echo '
          </UL>';
        ?> 
      </DIV>
    </DIV>
    <?php if($edit){ ?>
    <SCRIPT type="text/javascript">
      // code for editing blocks in Articles
      function UI(id){
        return '<DIV>article: <SPAN CLASS="item UI_article" ID="'+id+'.0"></SPAN></DIV>'
             + '<DIV>act: <UL><LI CLASS="new UI_act" ID="'+id+'.1">new act</LI></UL></DIV>'
             + '<DIV>organ: <UL><LI CLASS="new UI_organ" ID="'+id+'.2">new organ</LI></UL></DIV>'
             + '<DIV>verb: <UL><LI CLASS="new UI_verb" ID="'+id+'.3">new verb</LI></UL></DIV>'
             + '<DIV>object type: <UL><LI CLASS="new UI_objecttype" ID="'+id+'.4">new object type</LI></UL></DIV>'
              ;
      }
    </SCRIPT>
    <?php } ?>
    <?php
    if($edit) echo '</FORM>';
  if(!$edit) $buttons.=ifaceButton($_SERVER['PHP_SELF']."?edit=1","Edit");
  else
    $buttons.=ifaceButton("JavaScript:save('".$_SERVER['PHP_SELF']."?save=1');","Save")
             .ifaceButton($_SERVER['PHP_SELF'],"Cancel");
  writeTail($buttons);
?>