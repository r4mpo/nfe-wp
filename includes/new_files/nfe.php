<?php
require_once __DIR__ . '/admin.php';
$id = base64_decode($_GET['id']);
$order = wc_get_order($id);
$adm = get_user_by('ID', 1);
$valueItems = [];
$configuracoes = get_option('nfe_wp_dados');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="nfe/css/style.css">
    <script src="nfe/js/script.js"></script>


    <title>GERAR NF-E</title>
</head>

<body>
    <form action="nfe/backend/nfe.php" method="post">
        <div class="dados-iniciais-nfe">
            <h4>DADOS INICIAIS DO TX2</h4>

            <div class="input-group mb-3">

                <div class="form-floating">
                    <input required type="text" onkeypress="return apenasNumeros();" id="numlot" name="numlot"
                        class="form-control" placeholder="Nº do Lote" value="<?php echo $id; ?>" aria-label="Username"
                        maxlength="20" aria-describedby="basic-addon1">
                    <label for="numlot">Nº do Lote</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="cUF_B02" name="cUF_B02" class="form-control"
                        placeholder="Código UF do Estado Destinatário" value="<?php echo $order->shipping_state; ?>"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="cUF_B02">Código UF do Estado Destinatário</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="natOp_B04"
                        value="Realização de venda de mercadorias solicitadas por <?php echo $order->get_user()->display_name; ?>"
                        name="natOp_B04" class="form-control" placeholder="Descrição da operação" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="natOp_B04">Descrição da operação</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="mod_B06" name="mod_B06" value="55" class="form-control"
                        onkeypress="return apenasNumeros();" placeholder="Código da operação" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="mod_B06">Código da operação</label>
                </div>

            </div>

            <div class="input-group mb-3" id="bloco-dados-iniciais-nfe-selects">

                <div class="form-floating">
                    <select id="tpNF_B11" name="tpNF_B11" class="form-select" aria-label="Default select example">
                        <option value="0">Entrada</option>
                        <option selected value="1">Saída</option>
                    </select>
                    <label for="tpNF_B11">Tipo de Operação</label>
                </div>

                <div class="form-floating">
                    <select id="finNFe_B25" name="finNFe_B25" class="form-select" aria-label="Default select example">
                        <option selected value="1">NF-e normal</option>
                        <option value="2">NF-e complementar</option>
                        <option value="3">NF-e de ajuste</option>
                        <option value="4">Devolução de mercadoria</option>
                    </select>
                    <label for="finNFe_B25">Versão da NF-e</label>
                </div>

                <div class="form-floating">
                    <select id="INDPRES_B25B" name="INDPRES_B25B" class="form-select"
                        aria-label="Default select example">
                        <option value="0">Não se aplica</option>
                        <option value="1">Operação presencial</option>
                        <option selected value="2">Operação não presencial, pela Internet</option>
                        <option value="3">Operação não presencial, Teleatendimento</option>
                        <option value="4">NFC-e em operação com entrega a domicílio</option>
                        <option value="5">Operação presencial, fora do estabelecimento</option>
                        <option value="9">Operação não presencial, outros</option>
                    </select>
                    <label for="INDPRES_B25B">Presença do Comprador na Emissão</label>
                </div>

                <div class="form-floating">
                    <select id="procEmi_B26" name="procEmi_B26" class="form-select" aria-label="Default select example">
                        <option value="0">Emissão de NF-e com aplicativo do contribuinte</option>
                        <option value="1">Emissão de NF-e avulsa pelo Fisco</option>
                        <option selected value="2">Emissão de NF-e avulsa, pelo contribuinte com seu certificado
                            digital,
                            através do site do Fisco</option>
                        <option value="3">Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.</option>
                    </select>
                    <label for="procEmi_B26">Processo de emissão de NF-e</label>
                </div>


            </div>
        </div>

        <div class="dados-iniciais-nfe">
            <h4>EMITENTE</h4>

            <div class="input-group mb-3">

                <div class="form-floating">
                    <input required type="text" value="<?php echo $adm->display_name; ?>" id="xNome_C03"
                        name="xNome_C03" class="form-control" placeholder="Nome" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="xNome_C03">Nome</label>
                </div>

                <div class="form-floating">
                    <input required type="text" onkeypress="return apenasNumeros();"
                        value="<?php echo get_user_meta($adm->ID, 'shipping_postcode', true); ?>"
                        onkeyup="viaCep('CEP_C13', 'xBairro_C09', 'xMun_C11', 'UF_C12', 'xLgr_C06')" id="CEP_C13"
                        name="CEP_C13" class="form-control" placeholder="CEP" aria-label="Username" maxlength="8"
                        aria-describedby="basic-addon1">
                    <label for="CEP_C13">CEP</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="xBairro_C09" name="xBairro_C09" class="form-control"
                        placeholder="Bairro" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="xBairro_C09">Bairro</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="xMun_C11" name="xMun_C11" class="form-control"
                        placeholder="Município" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="xMun_C11">Município</label>
                </div>
            </div>

            <div class="input-group mb-3" id="bloco-dados-iniciais-nfe-selects">
                <div class="form-floating">
                    <input required type="text" onkeypress="return apenasNumeros();" id="cMun_C10" name="cMun_C10"
                        class="form-control border-green" placeholder="Cód. Município" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="cMun_C10">Cód. Município</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="UF_C12" name="UF_C12" class="form-control" placeholder="Estado"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="UF_C12">Estado</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="xLgr_C06" name="xLgr_C06" class="form-control"
                        placeholder="Logradouro" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="xLgr_C06">Logradouro</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="fone_C16"
                        value="<?php echo get_user_meta($adm->ID, 'billing_phone', true); ?>" name="fone_C16"
                        class="form-control" placeholder="Telefone" aria-label="Username"
                        onkeypress="return apenasNumeros();" maxlength="20" aria-describedby="basic-addon1">
                    <label for="fone_C16">Telefone</label>
                </div>
            </div>

        </div>

        <div class="dados-iniciais-nfe">
            <h4>DADOS ADICIONAIS DO TX2</h4>

            <div class="input-group mb-3">

                <div class="form-floating">
                    <select id="CRT_C21" name="CRT_C21" class="form-select" aria-label="Default select example">
                        <option selected value="1">Simples Nacional</option>
                        <option value="2">Simples Nacional, excesso sublimite de receita bruta</option>
                        <option value="3">Regime Normal.</option>
                    </select>
                    <label for="CRT_C21">Código Regime Tributário</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="INDIEDEST_E16A" name="INDIEDEST_E16A" class="form-control"
                        placeholder="Código Inscrição Estadual (Destinatário)" value="9"
                        onkeypress="return apenasNumeros();" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="INDIEDEST_E16A">Código Inscrição Estadual (Destinatário)</label>
                </div>

                <div class="form-floating">
                    <select id="IDDEST_B11A" required name="IDDEST_B11A" class="form-select"
                        aria-label="Default select example">
                        <option selected value="">ID do Local de Destino</option>
                        <option <?php if($configuracoes['id_local_de_destino'] == "1"): ?> selected <?php endif;?> value="1">Operação interna</option>
                        <option <?php if($configuracoes['id_local_de_destino'] == "2"): ?> selected <?php endif;?> value="2">Operação interestadual</option>
                        <option <?php if($configuracoes['id_local_de_destino'] == "3"): ?> selected <?php endif;?> value="3">Operação com exterior</option>
                    </select>
                    <label for="IDDEST_B11A">ID do Local de Destino</label>
                </div>
            </div>
        </div>

        <div class="dados-iniciais-nfe">
            <h4>DESTINATÁRIO</h4>

            <div class="input-group mb-3">

                <div class="form-floating">
                    <input required type="text" id="nro_E07" name="nro_E07" class="form-control" placeholder="Nº"
                        onkeypress="return apenasNumeros();" value="<?php echo $order->get_meta_data()[6]->value; ?>"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="nro_E07">Nº</label>
                </div>

                <?php if ($order->get_meta_data()[1]->value): ?>
                <div class="form-floating">
                    <input required type="text" id="CNPJ_E02" value="<?php echo $order->get_meta_data()[1]->value; ?>"
                        onkeypress="return apenasNumeros();" name="CNPJ_E02" class="form-control" placeholder="CNPJ"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="CNPJ_E02">CNPJ</label>
                </div>
                <?php endif; ?>

                <?php if ($order->get_meta_data()[2]->value): ?>
                <div class="form-floating">
                    <input required type="text" id="CPF_E03" value="<?php echo $order->get_meta_data()[2]->value; ?>"
                        onkeypress="return apenasNumeros();" name="CPF_E03" class="form-control" placeholder="CNPJ"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="CPF_E03">CPF</label>
                </div>
                <?php endif; ?>

                <div class="form-floating">
                    <input required type="text" id="xNome_E04" name="xNome_E04"
                        value="<?php echo $order->get_user()->display_name; ?>" class="form-control" placeholder="Nome"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="xNome_E04">Nome</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="CEP_E13" name="CEP_E13" class="form-control" placeholder="CEP"
                        aria-label="Username" value="<?php echo $order->shipping_postcode; ?>"
                        onkeypress="return apenasNumeros();"
                        onkeyup="viaCep('CEP_E13', 'xBairro_E09', 'xMun_E11', 'UF_E12', 'xLgr_E06')" maxlength="8"
                        aria-describedby="basic-addon1">
                    <label for="CEP_E13">CEP</label>
                </div>

            </div>

            <div class="input-group mb-3" id="bloco-dados-iniciais-nfe-selects">

                <div class="form-floating">
                    <input required type="text" id="xBairro_E09" name="xBairro_E09" class="form-control"
                        placeholder="Bairro" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="xBairro_E09">Bairro</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="xMun_E11" name="xMun_E11" class="form-control"
                        placeholder="Município do destinatário" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="xMun_E11">Município do destinatário</label>
                </div>

                <div class="form-floating">
                    <input required type="text" onkeypress="return apenasNumeros();" id="cMun_E10" name="cMun_E10"
                        class="form-control border-green" placeholder="Cód. Município" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="cMun_E10">Cód. Município</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="UF_E12" name="UF_E12" class="form-control"
                        placeholder="Estado do destinatário" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="UF_E12">Estado do destinatário</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="xLgr_E06" name="xLgr_E06" class="form-control"
                        placeholder="Logradouro do destinatário" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="xLgr_E06">Logradouro do destinatário</label>
                </div>

            </div>
        </div>

        <?php
        $contador = 0;
        foreach ($order->get_items() as $item_key => $item): ?>

        <div class="dados-iniciais-nfe">
            <h4>ITEM:
                <?php echo $item->get_name(); ?>
            </h4>
            <div class="input-group mb-3">

                <!-- Global Trade Item Number -->
                <div class="form-floating">
                    <input required type="text" id="item[<?php echo $contador; ?>]['cEAN_I03']"
                        value="<?php echo wc_get_product($item->get_product_id())->get_sku(); ?>"
                        name="item[<?php echo $contador; ?>]['cEAN_I03']" class="form-control"
                        placeholder="Código de Barras" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="item[<?php echo $contador; ?>]['cEAN_I03']">Código de Barras</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="item[<?php echo $contador; ?>]['vUnTrib_I14a']"
                        name="item[<?php echo $contador; ?>]['vUnTrib_I14a']" class="form-control currency"
                        placeholder="Valor tributo unitário" onkeyup="formatarMoeda(this.id);" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="item[<?php echo $contador; ?>]['vUnTrib_I14a']">Valor Tributo Unitário</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="item[<?php echo $contador; ?>]['nItem_H02']"
                        value="<?php echo $item->get_product_id(); ?>" onkeypress="return apenasNumeros();"
                        name="item[<?php echo $contador; ?>]['nItem_H02']" class="form-control"
                        placeholder="ID do Produto" aria-label="Username" aria-describedby="basic-addon1">
                    <label for="item[<?php echo $contador; ?>]['nItem_H02']">ID do Produto</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="item[<?php echo $contador; ?>]['xProd_I04']"
                        name="item[<?php echo $contador; ?>]['xProd_I04']" class="form-control"
                        placeholder="Breve descrição do produto" value="<?php echo $item->get_name(); ?>"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="item[<?php echo $contador; ?>]['xProd_I04']">Breve descrição do produto</label>
                </div>

                <div class="form-floating">
                    <select id="item[<?php echo $contador; ?>]['uCom_I09']"
                        name="item[<?php echo $contador; ?>]['uCom_I09']" class="form-select"
                        aria-label="Default select example">
                        <option selected value="UN">UNIDADE</option>
                        <option value="G">GRAMA</option>
                        <option value="JOGO">JOGO</option>
                        <option value="LT">LITRO</option>
                        <option value="M">METRO</option>
                        <option value="M2">METRO QUADRADO</option>
                    </select>
                    <label for="item[<?php echo $contador; ?>]['uCom_I09']">Tipo de unidade do produto</label>
                </div>


            </div>


            <div class="input-group mb-3" id="bloco-dados-iniciais-nfe-selects">

                <div class="form-floating">
                    <input required type="text" id="item[<?php echo $contador; ?>]['qCom_I10']"
                        name="item[<?php echo $contador; ?>]['qCom_I10']" onkeypress="return apenasNumeros();"
                        class="form-control" value="<?php echo $item->get_quantity(); ?>" placeholder="Qtd. Produto"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="item[<?php echo $contador; ?>]['qCom_I10']">Qtd. Produto</label>
                </div>


                <div class="form-floating">
                    <input required type="text" id="item[<?php echo $contador; ?>]['vUnCom_I10a']"
                        name="item[<?php echo $contador; ?>]['vUnCom_I10a']" class="form-control currency"
                        placeholder="Valor Un. Produto" onkeyup="formatarMoeda(this.id);"
                        value="<?php echo $item->get_product()->get_price(); ?>" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="item[<?php echo $contador; ?>]['vUnCom_I10a']">Valor Un. Produto</label>
                </div>


                <div class="form-floating">
                    <select id="item[<?php echo $contador; ?>]['orig_N11']"
                        name="item[<?php echo $contador; ?>]['orig_N11']" class="form-select"
                        aria-label="Default select example">
                        <option selected value="0">Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8</option>
                        <option value="1">Estrangeira - Importação direta, exceto a indicada no código 6</option>
                        <option value="2">Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7
                        </option>
                        <option value="3">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e
                            inferior
                            ou
                            igual a 70%</option>
                        <option value="4">Nacional, cuja produção tenha sido feita em conformidade (...)</option>
                        <option value="5">Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%
                        </option>
                        <option value="6">Estrangeira - Importação direta, sem similar nacional, constante em lista da
                            CAMEX
                            e
                            gás natural</option>
                        <option value="7">Estrangeira - Adquirida no mercado interno, sem similar nacional, constante
                            lista
                            CAMEX e gás natural.</option>
                        <option value="8">Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%</option>
                    </select>
                    <label for="orig_N11">Origem da mercadoria</label>
                </div>

                <div class="form-floating">
                    <select id="item[<?php echo $contador; ?>]['CST_Q06']"
                        name="item[<?php echo $contador; ?>]['CST_Q06']" class="form-select"
                        aria-label="Default select example">
                        <option value="01">Operação Tributável (base de cálculo = valor da operação alíquota normal
                            (cumulativo/não cumulativo))</option>
                        <option selected value="02">Operação Tributável (base de cálculo = valor da operação (alíquota
                            diferenciada))
                        </option>
                    </select>
                    <label for="item[<?php echo $contador; ?>]['CST_Q06']">Código de Situação Tributária do PIS</label>
                </div>

                <div class="form-floating">
                    <select id="item[<?php echo $contador; ?>]['CST_S06']"
                        name="item[<?php echo $contador; ?>]['CST_S06']" class="form-select"
                        aria-label="Default select example">
                        <option value="01">Operação Tributável (base de cálculo = valor da operação alíquota normal
                            (cumulativo/não cumulativo))</option>
                        <option selected value="02">Operação Tributável (base de cálculo = valor da operação (alíquota
                            diferenciada))
                        </option>
                    </select>
                    <label for="item[<?php echo $contador; ?>]['CST_S06']">Código de Situação Tributária do PIS</label>
                </div>


            </div>

        </div>

        <?php
            $valueItems[] = $item->get_product()->get_price() * $item->get_quantity();
            $contador = $contador + 1;
        endforeach;
        ?>

        <div class="dados-iniciais-nfe">
            <h4>CONSIDERAÇÕES FINAIS</h4>

            <div class="input-group mb-3">

                <div class="form-floating">
                    <input required type="text" id="vNF_W16" name="vNF_W16"
                        value="<?php echo 'R$ ' . number_format(array_sum($valueItems), 2, '.', ''); ?>"
                        class="form-control currency" placeholder="Valor total da NF-e" aria-label="Username"
                        onkeyup="formatarMoeda(this.id);" aria-describedby="basic-addon1">
                    <label for="vNF_W16">Valor total da NF-e</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vPag_YA03" name="vPag_YA03" onkeyup="formatarMoeda(this.id);"
                        class="form-control currency" placeholder="Valor a ser pago"
                        value="<?php echo $order->get_total(); ?>" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="vPag_YA03">Valor a ser pago</label>
                </div>

                <input required type="hidden" id="valorASerPago" value="<?php echo $order->get_total(); ?>">

                <div class="form-floating">
                    <input required type="text" id="vBC_W03" value="0" name="vBC_W03" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" placeholder="BC ICMS" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="vBC_W03">BC ICMS</label>
                </div>


                <div class="form-floating">
                    <input required type="text" id="vICMS_W04" value="0" name="vICMS_W04"
                        onkeyup="formatarMoeda(this.id);" class="currency form-control" placeholder="TOTAL ICMS"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="vICMS_W04">TOTAL ICMS</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vICMSDeson_W04a" value="0" name="vICMSDeson_W04a"
                        onkeyup="formatarMoeda(this.id);" class="currency form-control" placeholder="ICMS DESONERADO"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="vICMSDeson_W04a">ICMS DESONERADO</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vBCST_W05" name="vBCST_W05" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" placeholder="BC ICMS ST" value="0" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="vBCST_W05">BC ICMS ST</label>
                </div>


            </div>

            <div class="input-group mb-3" id="bloco-dados-iniciais-nfe-selects">

                <div class="form-floating">
                    <input required type="text" id="vST_W06" name="vST_W06" value="0" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" placeholder="TOTAL ICMS ST" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="vST_W06">TOTAL ICMS ST</label>
                </div>

                <div class="form-floating">
                    <select required id="modFrete_X02" name="modFrete_X02" class="form-select"
                        aria-label="Default select example">
                        <option selected value="">Modalidade do frete</option>
                        <option <?php if($configuracoes['modalidade_frete'] == "0"): ?> selected <?php endif;?> value="0">Contratação do Frete por conta do Remetente (CIF)</option>
                        <option <?php if($configuracoes['modalidade_frete'] == "1"): ?> selected <?php endif;?> value="1">Contratação do Frete por conta do Destinatário (FOB)</option>
                        <option <?php if($configuracoes['modalidade_frete'] == "2"): ?> selected <?php endif;?> value="2">Contratação do Frete por conta de Terceiros</option>
                        <option <?php if($configuracoes['modalidade_frete'] == "3"): ?> selected <?php endif;?> value="3">Transporte Próprio por conta do Remetente</option>
                        <option <?php if($configuracoes['modalidade_frete'] == "4"): ?> selected <?php endif;?> value="4">Transporte Próprio por conta do Destinatário</option>
                        <option <?php if($configuracoes['modalidade_frete'] == "9"): ?> selected <?php endif;?> value="9">Sem Ocorrência de Transporte</option>
                    </select>
                    <label for="modFrete_X02">Modalidade do frete</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vProd_W07"
                        value="<?php echo 'R$ ' . number_format(array_sum($valueItems), 2, '.', ''); ?>"
                        name="vProd_W07" class="form-control" onkeyup="formatarMoeda(this.id);"
                        placeholder="Valor total dos produtos" aria-describedby="basic-addon1">
                    <label for="vProd_W07">Valor total dos produtos</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vFrete_W08" onkeyup="formatarMoeda(this.id);" value="0"
                        name="vFrete_W08" class="currency form-control" placeholder="Valor do frete"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="vFrete_W08">Valor do frete</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vSeg_W09" name="vSeg_W09" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" placeholder="Valor total do seguro" value="0"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="vSeg_W09">Valor total do seguro</label>
                </div>


                <div class="form-floating">
                    <input required type="text" id="vDesc_W10" name="vDesc_W10" onkeyup="formatarMoeda(this.id);"
                        class="form-control" placeholder="Valor total do desconto"
                        value="R$ <?php echo $order->get_total_discount(); ?>" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="vDesc_W10">Valor total do desconto</label>
                </div>
            </div>

            <div class="input-group mb-3" id="bloco-dados-iniciais-nfe-selects">

                <div class="form-floating">
                    <input required type="text" id="vII_W11" name="vII_W11" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" placeholder="II" aria-label="Username" value="0"
                        aria-describedby="basic-addon1">
                    <label for="vII_W11">II</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vIPI_W12" name="vIPI_W12" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" placeholder="IPI" aria-label="Username" value="0"
                        aria-describedby="basic-addon1">
                    <label for="vIPI_W12">IPI</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vPIS_W13" name="vPIS_W13" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" value="0" placeholder="PIS" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="vPIS_W13">PIS</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vCOFINS_W14" value="0" name="vCOFINS_W14"
                        onkeyup="formatarMoeda(this.id);" class="currency form-control" placeholder="COFINS"
                        aria-label="Username" aria-describedby="basic-addon1">
                    <label for="vCOFINS_W14">COFINS</label>
                </div>


                <div class="form-floating">
                    <select id="tPag_YA02" required name="tPag_YA02" class="form-select"
                        aria-label="Default select example">
                        <option selected value="">Selecione o método de pagamento</option>
                        <option <?php if($configuracoes['metodo_pagamento'] == "03"): ?> selected <?php endif;?> value="03">Cartão de crédito</option>
                        <option <?php if($configuracoes['metodo_pagamento'] == "04"): ?> selected <?php endif;?> value="04">Cartão de débito</option>
                        <option <?php if($configuracoes['metodo_pagamento'] == "15"): ?> selected <?php endif;?> value="15">Boleto Bancário</option>
                        <option <?php if($configuracoes['metodo_pagamento'] == "16"): ?> selected <?php endif;?> value="16">Depósito Bancário</option>
                    </select>
                    <label for="tPag_YA02">Método de Pagamento</label>
                </div>

                <div class="form-floating">
                    <input required type="text" id="vOutro_W15" name="vOutro_W15" onkeyup="formatarMoeda(this.id);"
                        class="currency form-control" placeholder="Outras despesas" aria-label="Username"
                        aria-describedby="basic-addon1">
                    <label for="vOutro_W15">Outras despesas (R$)</label>
                </div>

                <button required type="button" onclick="somarOutrasDespesasNoValorTotalNfe()"
                    class="btn btn-outline-dark"><i class="bi bi-plus-lg"></i></button>
            </div>

            <div class="input-group mb-3">
                <div class="form-floating">
                    <textarea required class="form-control border-green" id="infCpl_Z03" name="infCpl_Z03"
                        style="height: 100px"><?php echo $configuracoes['descricao_padrao'];?></textarea>
                    <label for="infCpl_Z03">Descrição da documentação</label>
                </div>
            </div>

            <!-- Configurações -->
            <input type="hidden" name="content_type" value="<?php echo $configuracoes['content_type']; ?>">
            <input type="hidden" name="authorization" value="<?php echo $configuracoes['authorization']; ?>">
            <input type="hidden" name="nome" value="<?php echo $configuracoes['nome']; ?>">
            <input type="hidden" name="grupo" value="<?php echo $configuracoes['grupo']; ?>">
            <input type="hidden" name="cnpj" value="<?php echo $configuracoes['cnpj']; ?>">
            <input type="hidden" name="CNPJ_C02" value="<?php echo $configuracoes['CNPJ_C02']; ?>">
            <input type="hidden" name="nro_C07" value="<?php echo $configuracoes['nro_C07']; ?>">
            <input type="hidden" name="IE_C17" value="<?php echo $configuracoes['IE_C17']; ?>">
            <input type="hidden" name="cProd_I02" value="<?php echo $configuracoes['cProd_I02']; ?>">
            <input type="hidden" name="cNF_B03" value="<?php echo $configuracoes['cNF_B03']; ?>">
            <input type="hidden" name="Formato" value="<?php echo $configuracoes['Formato']; ?>">
            <input type="hidden" name="numlote" value="<?php echo $configuracoes['numlote']; ?>">
            <input type="hidden" name="versao_A02" value="<?php echo $configuracoes['versao_A02']; ?>">
            <input type="hidden" name="tpImp_B21" value="<?php echo $configuracoes['tpImp_B21']; ?>">
            <input type="hidden" name="tpEmis_B22" value="<?php echo $configuracoes['tpEmis_B22']; ?>">
            <input type="hidden" name="cDV_B23" value="<?php echo $configuracoes['cDV_B23']; ?>">
            <input type="hidden" name="tpAmb_B24" value="<?php echo $configuracoes['tpAmb_B24']; ?>">
            <input type="hidden" name="INDFINAL_B25A" value="<?php echo $configuracoes['INDFINAL_B25A']; ?>">
            <input type="hidden" name="verProc_B27" value="<?php echo $configuracoes['verProc_B27']; ?>">
            <input type="hidden" name="uTrib_I13" value="<?php echo $configuracoes['uTrib_I13']; ?>">
            <input type="hidden" name="indTot_I17b" value="<?php echo $configuracoes['indTot_I17b']; ?>">
            <input type="hidden" name="CST_N12" value="<?php echo $configuracoes['CST_N12']; ?>">
            <input type="hidden" name="vFCPST_W06a" value="<?php echo $configuracoes['vFCPST_W06a']; ?>">
            <input type="hidden" name="vFCPSTRet_W06b" value="<?php echo $configuracoes['vFCPSTRet_W06b']; ?>">
            <input type="hidden" name="NCM_I05" value="<?php echo $configuracoes['NCM_I05']; ?>">
            <input type="hidden" name="CEST_I05c" value="<?php echo $configuracoes['CEST_I05c']; ?>">
            <input type="hidden" name="CNPJ_ZD02" value="<?php echo $configuracoes['CNPJ_ZD02']; ?>">
            <input type="hidden" name="xContato_ZD04" value="<?php echo $configuracoes['xContato_ZD04']; ?>">
            <input type="hidden" name="email_ZD05" value="<?php echo $configuracoes['email_ZD05']; ?>">
            <input type="hidden" name="fone_ZD06" value="<?php echo $configuracoes['fone_ZD06']; ?>">
            <input type="hidden" name="serie_B07" value="<?php echo $configuracoes['serie_B07']; ?>">
            <input type="hidden" name="nNF_B08" value="<?php echo $configuracoes['nNF_B08']; ?>">

            <div>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-success" type="submit"><i class="bi bi-filetype-txt"></i></button>
                </div>
            </div>

        </div>
    </form>

</body>

</html>

</html>

</html>

</html>