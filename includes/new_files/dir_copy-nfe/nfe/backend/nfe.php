<?php
$tx2 = fopen(getcwd() . "/../tx2/" . date("Y-m-d h-i-s") . '.TX2', "a");

fwrite($tx2, "Formato=" . $_POST["Formato"]);
fwrite($tx2, "\nnumlote=" . $_POST["numlote"]);
fwrite($tx2, "\nINCLUIR");
fwrite($tx2, "\nId_A03=0"); // Este campo recebe o valor 0 pois se preenche automaticamente na API;
fwrite($tx2, "\nversao_A02=" . $_POST["versao_A02"]);
fwrite($tx2, "\ncUF_B02=" . $_POST["cUF_B02"]);
fwrite($tx2, "\ncNF_B03=" . $_POST["cNF_B03"]);
fwrite($tx2, "\nnatOp_B04=" . $_POST["natOp_B04"]);
fwrite($tx2, "\nmod_B06=" . $_POST["mod_B06"]);
fwrite($tx2, "\nserie_B07=" . $_POST["serie_B07"]);
fwrite($tx2, "\nnNF_B08=" . $_POST["nNF_B08"]);
fwrite($tx2, "\nDHEMI_B09=" . (date('Y-m-d') . 'T' . date('h:i:s')));
fwrite($tx2, "\ntpNF_B11=" . $_POST["tpNF_B11"]);
fwrite($tx2, "\nIDDEST_B11A=" . $_POST["IDDEST_B11A"]);
fwrite($tx2, "\ncMunFG_B12=" . $_POST["cMun_C10"]);
fwrite($tx2, "\ntpImp_B21=" . $_POST["tpImp_B21"]);
fwrite($tx2, "\ntpEmis_B22=" . $_POST["tpEmis_B22"]);
fwrite($tx2, "\ncDV_B23=" . $_POST["cDV_B23"]);
fwrite($tx2, "\ntpAmb_B24=" . $_POST["tpAmb_B24"]);
fwrite($tx2, "\nfinNFe_B25=" . $_POST["finNFe_B25"]);
fwrite($tx2, "\nINDFINAL_B25A=" . $_POST["INDFINAL_B25A"]);
fwrite($tx2, "\nINDPRES_B25B=" . $_POST["INDPRES_B25B"]);
fwrite($tx2, "\nprocEmi_B26=" . $_POST["procEmi_B26"]);
fwrite($tx2, "\nverProc_B27=" . $_POST["verProc_B27"]);
fwrite($tx2, "\nCRT_C21=" . $_POST["CRT_C21"]);
fwrite($tx2, "\nCNPJ_C02=" . $_POST["CNPJ_C02"]);
fwrite($tx2, "\nxNome_C03=" . $_POST["xNome_C03"]);
fwrite($tx2, "\nxLgr_C06=" . $_POST["xLgr_C06"]);
fwrite($tx2, "\nnro_C07=" . $_POST["nro_C07"]);
fwrite($tx2, "\nxBairro_C09=" . $_POST["xBairro_C09"]);
fwrite($tx2, "\ncMun_C10=" . $_POST["cMun_C10"]);
fwrite($tx2, "\nxMun_C11=" . $_POST["xMun_C11"]);
fwrite($tx2, "\nUF_C12=" . $_POST["UF_C12"]);
fwrite($tx2, "\nCEP_C13=" . $_POST["CEP_C13"]);
fwrite($tx2, "\nfone_C16=" . $_POST["fone_C16"]);
fwrite($tx2, "\nIE_C17=" . $_POST["IE_C17"]);
fwrite($tx2, "\nCNPJ_E02=" . $_POST["CNPJ_E02"]);
fwrite($tx2, "\nIDESTRANGEIRO_E03A="); // colocar campo opcional no formulário
fwrite($tx2, "\nxNome_E04=" . $_POST["xNome_E04"]);
fwrite($tx2, "\nxLgr_E06=" . $_POST["xLgr_E06"]);
fwrite($tx2, "\nnro_E07=" . $_POST["nro_E07"]);
fwrite($tx2, "\nxBairro_E09=" . $_POST["xBairro_E09"]);
fwrite($tx2, "\ncMun_E10=" . $_POST["cMun_E10"]);
fwrite($tx2, "\nxMun_E11=" . $_POST["xMun_E11"]);
fwrite($tx2, "\nUF_E12=" . $_POST["UF_E12"]);
fwrite($tx2, "\nCEP_E13=" . $_POST["CEP_E13"]);
fwrite($tx2, "\nINDIEDEST_E16A=" . $_POST["INDIEDEST_E16A"]);

$item = $_POST['item'];

for ($i = 0; $i < count($item); $i++) {
    fwrite($tx2, "\nINCLUIRITEM");
    fwrite($tx2, "\nnItem_H02=" . $item[$i]["'nItem_H02'"]);
    fwrite($tx2, "\ncProd_I02=" . $_POST["cProd_I02"]);
    fwrite($tx2, "\ncEAN_I03=" . $item[$i]["'cEAN_I03'"]);
    fwrite($tx2, "\nxProd_I04=" . $item[$i]["'xProd_I04'"]);
    fwrite($tx2, "\nNCM_I05=" . $_POST["NCM_I05"]);
    fwrite($tx2, "\nCEST_I05c=" . $_POST["CEST_I05c"]);
    fwrite($tx2, "\nCFOP_I08=" .  $_POST["cProd_I02"]);
    fwrite($tx2, "\nuCom_I09=" . $item[$i]["'uCom_I09'"]);
    fwrite($tx2, "\nqCom_I10=" . $item[$i]["'qCom_I10'"]);
    fwrite($tx2, "\nvUnCom_I10a=" . (preg_replace('/\D/', '', $item[$i]["'vUnCom_I10a'"])) / 100);
    fwrite($tx2, "\nvProd_I11=" . ((preg_replace('/\D/', '', $item[$i]["'vUnCom_I10a'"]) * $item[$i]["'qCom_I10'"]) / 100));
    fwrite($tx2, "\ncEANTrib_I12=" . $item[$i]["'cEAN_I03'"]);
    fwrite($tx2, "\nuTrib_I13=" . $_POST["uTrib_I13"]);
    fwrite($tx2, "\nqTrib_I14=" . $item[$i]["'qCom_I10'"]);
    fwrite($tx2, "\nvUnTrib_I14a=" . (preg_replace('/\D/', '', $item[$i]["'vUnTrib_I14a'"]) / 100));
    fwrite($tx2, "\nindTot_I17b=" . $_POST["indTot_I17b"]);
    fwrite($tx2, "\norig_N11=" . $item[$i]["'orig_N11'"]);
    fwrite($tx2, "\nCST_N12=" . $_POST["CST_N12"]);
    fwrite($tx2, "\nCST_Q06=" . $item[$i]["'CST_Q06'"]);
    fwrite($tx2, "\nCST_S06=" . $item[$i]["'CST_S06'"]);
    fwrite($tx2, "\nSALVARITEM");
}

fwrite($tx2, "\nvBC_W03=" . preg_replace('/\D/', '', $_POST["vBC_W03"]) / 100);
fwrite($tx2, "\nvICMS_W04=" . preg_replace('/\D/', '', $_POST["vICMS_W04"]) / 100);
fwrite($tx2, "\nvICMSDeson_W04a=" . preg_replace('/\D/', '', $_POST["vICMSDeson_W04a"]) / 100);
fwrite($tx2, "\nvBCST_W05=" . preg_replace('/\D/', '', $_POST["vBCST_W05"]) / 100);
fwrite($tx2, "\nvST_W06=" . preg_replace('/\D/', '', $_POST["vST_W06"]) / 100);
fwrite($tx2, "\nvFCPST_W06a=" . $_POST["vFCPST_W06a"]);
fwrite($tx2, "\nvFCPSTRet_W06b=" . $_POST["vFCPSTRet_W06b"]);
fwrite($tx2, "\nvProd_W07=" . preg_replace('/\D/', '', $_POST["vProd_W07"]) / 100);
fwrite($tx2, "\nvFrete_W08=" . preg_replace('/\D/', '', $_POST["vFrete_W08"]) / 100);
fwrite($tx2, "\nvSeg_W09=" . preg_replace('/\D/', '', $_POST["vSeg_W09"]) / 100);
fwrite($tx2, "\nvDesc_W10=" . preg_replace('/\D/', '', $_POST["vDesc_W10"]) / 100);
fwrite($tx2, "\nvII_W11=" . preg_replace('/\D/', '', $_POST["vII_W11"]) / 100);
fwrite($tx2, "\nvIPI_W12=" . preg_replace('/\D/', '', $_POST["vIPI_W12"]) / 100);
fwrite($tx2, "\nvPIS_W13=" . preg_replace('/\D/', '', $_POST["vPIS_W13"]) / 100);
fwrite($tx2, "\nvCOFINS_W14=" . preg_replace('/\D/', '', $_POST["vCOFINS_W14"]) / 100);
fwrite($tx2, "\nvOutro_W15=" . preg_replace('/\D/', '', $_POST["vOutro_W15"]) / 100);
fwrite($tx2, "\nvNF_W16=" . preg_replace('/\D/', '', $_POST["vNF_W16"]) / 100);
fwrite($tx2, "\nmodFrete_X02=" . $_POST["modFrete_X02"]);

fwrite($tx2, "\nINCLUIRPARTE=YA");
fwrite($tx2, "\ntPag_YA02=" . preg_replace('/\D/', '', $_POST["tPag_YA02"]) / 100);
fwrite($tx2, "\nvPag_YA03=" . preg_replace('/\D/', '', $_POST["vPag_YA03"]) / 100);
fwrite($tx2, "\nSALVARPARTE=YA");

fwrite($tx2, "\nCNPJ_ZD02=" . $_POST["CNPJ_ZD02"]);
fwrite($tx2, "\nxContato_ZD04=" . $_POST["xContato_ZD04"]);
fwrite($tx2, "\nemail_ZD05=" . $_POST["email_ZD05"]);
fwrite($tx2, "\nfone_ZD06=" . $_POST["fone_ZD06"]);

fwrite($tx2, "\ninfCpl_Z03=" . $_POST["infCpl_Z03"]);

fwrite($tx2, "\nSALVAR");
?>