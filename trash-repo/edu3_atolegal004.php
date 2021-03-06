<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */


require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
                   
    <?
      $sLib  = "scripts.js,prototype.js,webseller.js,strings.js,DBTreeView.widget.js,";
      $sLib .= "estilos.css";
      db_app::load($sLib);
    ?>
                                                  
  </head>
  <body>
    
    <div id="arvoreRH" name="arvoreRH">
    
    </div>

  </body>
</html>

<script language="JavaScript">

var oTreeViewRH = new DBTreeView('treeViewRH');

function js_inicializar() {

  oTreeViewRH.show($('arvoreRH'));
  js_buscaRH();

}

function js_buscaRH() {

  var oParam       = new Object();

  oParam.exec      = "getRecHumanoAtoLegal";
  oParam.iAtoLegal = <?=$iAtoLegal?>;

  var sUrl         = "edu4_escola.RPC.php";

  js_webajax(oParam, 'js_retornoBuscaRH', sUrl);

}

function js_retornoBuscaRH(oRetorno) {

  var oRetorno = eval("("+oRetorno.responseText+")");
  
  if (oRetorno.iStatus != 1) {

    oNoPrincipal = oTreeViewRH.addNode("0", "Nenhum Recurso Humano vinculado para este ato legal.");
    return false;

  } else {
    
    if (oRetorno.iAtividades < 1) {
      oNoPrincipal = oTreeViewRH.addNode("0", "Nenhum Recurso Humano vinculado para este ato legal.");
    } else {
    
      oNoPrincipal = oTreeViewRH.addNode("0", "Atividades");

      for (var iCont = 0; iCont < oRetorno.iAtividades; iCont++) {
        oTreeViewRH.addNode("P"+oRetorno.aAtividades[iCont].codigo,
                            oRetorno.aAtividades[iCont].descricao.urlDecode(), "0");
      }

      for (var iCont = 0; iCont < oRetorno.iRH; iCont++) {
        oTreeViewRH.addNode("S"+oRetorno.aRH[iCont].codigo,
                            oRetorno.aAtividades[iCont].codigo+" - "+
                            oRetorno.aRH[iCont].descricao.urlDecode(),
                            "P"+oRetorno.aRH[iCont].node_pai);
      }

    }

  }

}

js_inicializar();

</script>