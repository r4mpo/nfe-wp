<?php

if (!class_exists('nfe_wp_admin')) {
    class nfe_wp_admin
    {

        private $options;
        private $plugin_basename;
        private $version;
        private $plugin_slug;

        public function __construct($plugin_basename, $plugin_slug, $version)
        {

            $this->options = get_option('nfe_wp_dados');
            $this->plugin_basename = $plugin_basename;
            $this->plugin_slug = $plugin_slug;
            $this->version = $version;

            // Actions para ativar as funções desenvolvidas abaixo
            // Filter para criar URL de Configurações no plugin

            add_action('admin_menu', array($this, 'add_plugin_page'));
            add_action('admin_init', array($this, 'page_init'));
            add_filter("plugin_action_links_" . $this->plugin_basename, array($this, 'add_settings_link'));
        }

        public function add_plugin_page()
        {

            /* Definindo que o plugin terá uma opção "Configurações" em settings
            e um link anexado na própria barra do Wordpress. */

            add_options_page(
                'Settings',
                'NFE WP',
                'manage_options',
                $this->plugin_slug,
                array($this, 'create_admin_page')
            );

        }

        /*
        Nesta seguinte função, informamos que o formulário será composto por 
        seções e que deve inserir os dados na tabela especificada.
        */

        public function create_admin_page()
        {
?>
<!-- Formulário -->
<div class="wrap">
    <h1>Configurações da NF-e</h1>
    <form action="options.php" method="post">
        <?php
            settings_fields('nfe_wp_dados_options');
            do_settings_sections('nfe_wp_dados_admin');
            submit_button();
        ?>
    </form>
</div>
<?php
        }

        public function page_init()
        {
            register_setting(
                'nfe_wp_dados_options',
                'nfe_wp_dados',
                array($this, 'sanitize')
            );

            add_settings_section(
                'setting_section_id_1',
                'Headers',
            null,
                'nfe_wp_dados_admin'
            );

            add_settings_field(
                'content_type',
                'Content-Type',
                array($this, 'content_type_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_1',
            );

            add_settings_field(
                'authorization',
                'Authorization',
                array($this, 'authorization_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_1',
            );

            add_settings_section(
                'setting_section_id_2',
                'Body',
            null,
                'nfe_wp_dados_admin'
            );

            add_settings_field(
                'nome',
                'Nome',
                array($this, 'nome_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_2',
            );

            add_settings_field(
                'grupo',
                'Grupo',
                array($this, 'grupo_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_2',
            );

            add_settings_field(
                'cnpj',
                'CNPJ',
                array($this, 'cnpj_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_2',
            );

            add_settings_section(
                'setting_section_id_3',
                'Emitente',
            null,
                'nfe_wp_dados_admin'
            );

            add_settings_field(
                'CNPJ_C02',
                'CNPJ do emitente',
                array($this, 'CNPJ_C02_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_3',
            );

            add_settings_field(
                'nro_C07',
                'Nº Residencial do Emitente',
                array($this, 'nro_C07_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_3',
            );

            add_settings_field(
                'IE_C17',
                'Inscrição Estadual do Emitente',
                array($this, 'IE_C17_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_3',
            );

            add_settings_field(
                'cProd_I02',
                'CFOP',
                array($this, 'cProd_I02_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_3',
            );

            add_settings_field(
                'CEST_I05c',
                'CEST',
                array($this, 'CEST_I05c_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_3',
            );

            add_settings_field(
                'cNF_B03',
                'Chave de Acesso',
                array($this, 'cNF_B03_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_3',
            );

            add_settings_section(
                'setting_section_id_4',
                'Suporte técnico',
            null,
                'nfe_wp_dados_admin'
            );

            add_settings_field(
                'CNPJ_ZD02',
                'CNPJ da Software House',
                array($this, 'CNPJ_ZD02_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_4',
            );

            add_settings_field(
                'xContato_ZD04',
                'Nome do responsável técnico',
                array($this, 'xContato_ZD04_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_4',
            );

            add_settings_field(
                'email_ZD05',
                'E-mail do responsável técnico',
                array($this, 'email_ZD05_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_4',
            );

            add_settings_field(
                'fone_ZD06',
                'Telefone do responsável técnico',
                array($this, 'fone_ZD06_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_4',
            );

            add_settings_section(
                'setting_section_id_5',
                'Padronize campos do formulário',
            null,
                'nfe_wp_dados_admin'
            );

            add_settings_field(
                'serie_B07',
                'Nº Série Fiscal',
                array($this, 'serie_B07_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_5',
            );

            add_settings_field(
                'descricao_padrao',
                'Descrição',
                array($this, 'descricao_padrao_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_5',
            );

            add_settings_field(
                'id_local_de_destino',
                'ID do Local de Destino',
                array($this, 'id_local_de_destino_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_5',
            );

            add_settings_field(
                'modalidade_frete',
                'Modalidade de frete',
                array($this, 'modalidade_frete_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_5',
            );

            add_settings_field(
                'metodo_pagamento',
                'Método de pagamento',
                array($this, 'metodo_pagamento_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_5',
            );

            add_settings_section(
                'setting_section_id_6',
                'TX2',
            null,
                'nfe_wp_dados_admin'
            );

            add_settings_field(
                'Formato',
                'Formato',
                array($this, 'Formato_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'numlote',
                'Nº Lote',
                array($this, 'numlote_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'versao_A02',
                'Versão NF-e',
                array($this, 'versao_A02_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'tpImp_B21',
                'Formato de Impressão do DANFE',
                array($this, 'tpImp_B21_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'tpEmis_B22',
                'Tipo de Emissão da NF-e',
                array($this, 'tpEmis_B22_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'cDV_B23',
                'Dígito Verificador da Chave de Acesso da NF-e',
                array($this, 'cDV_B23_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'cDV_B23',
                'Dígito Verificador da Chave de Acesso da NF-e',
                array($this, 'cDV_B23_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'tpAmb_B24',
                'Tipo ambiente',
                array($this, 'tpAmb_B24_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'INDFINAL_B25A',
                'Indica operação com Consumidor final',
                array($this, 'INDFINAL_B25A_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'cDV_B23',
                'Dígito Verificador da Chave de Acesso da NF-e',
                array($this, 'cDV_B23_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'verProc_B27',
                'Software responsável pela integração com a Tecnospeed',
                array($this, 'verProc_B27_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'uTrib_I13',
                'Unidade de medida tributável',
                array($this, 'uTrib_I13_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'indTot_I17b',
                'Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)',
                array($this, 'indTot_I17b_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'indTot_I17b',
                'Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)',
                array($this, 'indTot_I17b_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'CST_N12',
                'Tributação do ICMS = 00',
                array($this, 'CST_N12_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'vFCPST_W06a',
                'Valor Total do FCP (Fundo de Combate à Pobreza) retido por substituição tributária',
                array($this, 'vFCPST_W06a_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'vFCPSTRet_W06b',
                'Valor Total do FCP retido anteriormente por Substituição Tributária',
                array($this, 'vFCPSTRet_W06b_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'NCM_I05',
                'Código NCM com 8 digitos',
                array($this, 'NCM_I05_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );

            add_settings_field(
                'nNF_B08',
                'Número do documento fiscal',
                array($this, 'nNF_B08_callback'),
                'nfe_wp_dados_admin',
                'setting_section_id_6',
            );
        }

        public function content_type_callback()
        {
            $value = isset($this->options['content_type']) ? esc_attr($this->options['content_type']) : 'application/json';
?>
<input type="text" id="content_type" name="nfe_wp_dados[content_type]" value="<?php echo $value; ?>" />
<?php
        }

        public function authorization_callback()
        {
            $value = isset($this->options['authorization']) ? esc_attr($this->options['authorization']) : '';
?>
<input type="text" maxlength="14" id="authorization" name="nfe_wp_dados[authorization]" value="<?php echo $value; ?>" />
<?php
        }

        public function nome_callback()
        {
            $value = isset($this->options['nome']) ? esc_attr($this->options['nome']) : '';
?>
<input type="text" id="nome" name="nfe_wp_dados[nome]" value="<?php echo $value; ?>" />
<?php
        }

        public function grupo_callback()
        {
            $value = isset($this->options['grupo']) ? esc_attr($this->options['grupo']) : '';
?>
<input type="text" maxlength="14" id="grupo" name="nfe_wp_dados[grupo]" value="<?php echo $value; ?>" />
<?php
        }

        public function cnpj_callback()
        {
            $value = isset($this->options['cnpj']) ? esc_attr($this->options['cnpj']) : '';
?>
<input type="number" id="cnpj" name="nfe_wp_dados[cnpj]" value="<?php echo $value; ?>" />
<?php
        }

        public function CNPJ_C02_callback()
        {
            $value = isset($this->options['CNPJ_C02']) ? esc_attr($this->options['CNPJ_C02']) : '';
?>
<input type="number" id="CNPJ_C02" name="nfe_wp_dados[CNPJ_C02]" value="<?php echo $value; ?>" />
<?php
        }

        public function nro_C07_callback()
        {
            $value = isset($this->options['nro_C07']) ? esc_attr($this->options['nro_C07']) : '';
?>
<input type="number" id="nro_C07" name="nfe_wp_dados[nro_C07]" value="<?php echo $value; ?>" />
<?php
        }

        public function IE_C17_callback()
        {
            $value = isset($this->options['IE_C17']) ? esc_attr($this->options['IE_C17']) : '';
?>
<input type="number" id="IE_C17" name="nfe_wp_dados[IE_C17]" value="<?php echo $value; ?>" />
<?php
        }

        public function cProd_I02_callback()
        {
            $value = isset($this->options['cProd_I02']) ? esc_attr($this->options['cProd_I02']) : '';
?>
<input type="text" id="cProd_I02" name="nfe_wp_dados[cProd_I02]" value="<?php echo $value; ?>" />
<?php
        }

        public function CEST_I05c_callback()
        {
            $value = isset($this->options['CEST_I05c']) ? esc_attr($this->options['CEST_I05c']) : '';
?>
<input type="text" id="CEST_I05c" name="nfe_wp_dados[CEST_I05c]" value="<?php echo $value; ?>" />
<?php
        }

        public function cNF_B03_callback()
        {
            $value = isset($this->options['cNF_B03']) ? esc_attr($this->options['cNF_B03']) : '';
?>
<input type="text" id="cNF_B03" name="nfe_wp_dados[cNF_B03]" value="<?php echo $value; ?>" />
<?php
        }

        public function CNPJ_ZD02_callback()
        {
            $value = isset($this->options['CNPJ_ZD02']) ? esc_attr($this->options['CNPJ_ZD02']) : '';
?>
<input type="number" id="CNPJ_ZD02" name="nfe_wp_dados[CNPJ_ZD02]" value="<?php echo $value; ?>" />
<?php
        }

        public function xContato_ZD04_callback()
        {
            $value = isset($this->options['xContato_ZD04']) ? esc_attr($this->options['xContato_ZD04']) : '';
?>
<input type="text" id="xContato_ZD04" name="nfe_wp_dados[xContato_ZD04]" value="<?php echo $value; ?>" />
<?php
        }

        public function email_ZD05_callback()
        {
            $value = isset($this->options['email_ZD05']) ? esc_attr($this->options['email_ZD05']) : '';
?>
<input type="email" id="email_ZD05" name="nfe_wp_dados[email_ZD05]" value="<?php echo $value; ?>" />
<?php
        }

        public function fone_ZD06_callback()
        {
            $value = isset($this->options['fone_ZD06']) ? esc_attr($this->options['fone_ZD06']) : '';
?>
<input type="number" id="fone_ZD06" name="nfe_wp_dados[fone_ZD06]" value="<?php echo $value; ?>" />
<?php
        }

        
        public function serie_B07_callback()
        {
            $value = isset($this->options['serie_B07']) ? esc_attr($this->options['serie_B07']) : '';
?>
<input type="text" id="serie_B07" name="nfe_wp_dados[serie_B07]" value="<?php echo $value; ?>">
<?php
        }

        public function descricao_padrao_callback()
        {
            $value = isset($this->options['descricao_padrao']) ? esc_attr($this->options['descricao_padrao']) : '';
?>
<textarea id="descricao_padrao" name="nfe_wp_dados[descricao_padrao]"><?php echo $value; ?></textarea>
<?php
        }

        public function id_local_de_destino_callback()
        {
            $value = isset($this->options['id_local_de_destino']) ? esc_attr($this->options['id_local_de_destino']) : '';
?>
<select id="id_local_de_destino" name="nfe_wp_dados[id_local_de_destino]">
    <option selected value="">ID do Local de Destino</option>
    <option <?php if ($value == "1"): ?> selected
        <?php endif; ?> value="1">Operação interna
    </option>
    <option <?php if ($value == "2"): ?> selected
        <?php endif; ?> value="2">Operação interestadual
    </option>
    <option <?php if ($value == "3"): ?> selected
        <?php endif; ?> value="3">Operação com exterior
    </option>

</select>
<?php
        }

        public function modalidade_frete_callback()
        {
            $value = isset($this->options['modalidade_frete']) ? esc_attr($this->options['modalidade_frete']) : '';
?>
<select id="modalidade_frete" name="nfe_wp_dados[modalidade_frete]">
    <option selected value="">Modalidade do frete</option>
    <option <?php if ($value == "0"): ?> selected
        <?php endif; ?> value="0">Contratação do Frete por conta do Remetente (CIF)
    </option>
    <option <?php if ($value == "1"): ?> selected
        <?php endif; ?> value="1">Contratação do Frete por conta do Destinatário (FOB)
    </option>
    <option <?php if ($value == "2"): ?> selected
        <?php endif; ?> value="2">Contratação do Frete por conta de Terceiros
    </option>
    <option <?php if ($value == "3"): ?> selected
        <?php endif; ?> value="3">Transporte Próprio por conta do Remetente
    </option>
    <option <?php if ($value == "4"): ?> selected
        <?php endif; ?> value="4">Transporte Próprio por conta do Destinatário
    </option>
    <option <?php if ($value == "9"): ?> selected
        <?php endif; ?> value="9">Sem Ocorrência de Transporte
    </option>

</select>
<?php
        }

        public function metodo_pagamento_callback()
        {
            $value = isset($this->options['metodo_pagamento']) ? esc_attr($this->options['metodo_pagamento']) : '';
?>
<select id="metodo_pagamento" name="nfe_wp_dados[metodo_pagamento]">
    <option selected value="">Selecione o método de pagamento</option>
    <option <?php if ($value == "03"): ?> selected
        <?php endif; ?> value="03">Cartão de crédito
    </option>
    <option <?php if ($value == "04"): ?> selected
        <?php endif; ?> value="04">Cartão de débito
    </option>
    <option <?php if ($value == "15"): ?> selected
        <?php endif; ?> value="15">Boleto Bancário
    </option>
    <option <?php if ($value == "16"): ?> selected
        <?php endif; ?> value="16">Depósito Bancário
    </option>
</select>
<?php
        }

        public function Formato_callback()
        {
            $value = isset($this->options['Formato']) ? esc_attr($this->options['Formato']) : 'tx2';
?>
<input type="text" id="Formato" name="nfe_wp_dados[Formato]" value="<?php echo $value; ?>" />
<?php
        }

        public function numlote_callback()
        {
            $value = isset($this->options['numlote']) ? esc_attr($this->options['numlote']) : '0';
?>
<input type="text" id="numlote" name="nfe_wp_dados[numlote]" value="<?php echo $value; ?>" />
<?php
        }

        public function versao_A02_callback()
        {
            $value = isset($this->options['versao_A02']) ? esc_attr($this->options['versao_A02']) : '4.00';
?>
<input type="text" id="versao_A02" name="nfe_wp_dados[versao_A02]" value="<?php echo $value; ?>" />
<?php
        }

        public function tpImp_B21_callback()
        {
            $value = isset($this->options['tpImp_B21']) ? esc_attr($this->options['tpImp_B21']) : '0';
?>
<input type="text" id="tpImp_B21" name="nfe_wp_dados[tpImp_B21]" value="<?php echo $value; ?>" />
<?php
        }

        public function tpEmis_B22_callback()
        {
            $value = isset($this->options['tpEmis_B22']) ? esc_attr($this->options['tpEmis_B22']) : '1';
?>
<input type="text" id="tpEmis_B22" name="nfe_wp_dados[tpEmis_B22]" value="<?php echo $value; ?>" />
<?php
        }

        public function cDV_B23_callback()
        {
            $value = isset($this->options['cDV_B23']) ? esc_attr($this->options['cDV_B23']) : '0';
?>
<input type="text" id="cDV_B23" name="nfe_wp_dados[cDV_B23]" value="<?php echo $value; ?>" />
<?php
        }

        public function tpAmb_B24_callback()
        {
            $value = isset($this->options['tpAmb_B24']) ? esc_attr($this->options['tpAmb_B24']) : '1';
?>
<input type="text" id="tpAmb_B24" name="nfe_wp_dados[tpAmb_B24]" value="<?php echo $value; ?>" />
<?php
        }

        public function INDFINAL_B25A_callback()
        {
            $value = isset($this->options['INDFINAL_B25A']) ? esc_attr($this->options['INDFINAL_B25A']) : '1';
?>
<input type="text" id="INDFINAL_B25A" name="nfe_wp_dados[INDFINAL_B25A]" value="<?php echo $value; ?>" />
<?php
        }

        public function verProc_B27_callback()
        {
            $value = isset($this->options['verProc_B27']) ? esc_attr($this->options['verProc_B27']) : 'NFEWP_0.0.1';
?>
<input type="text" id="verProc_B27" name="nfe_wp_dados[verProc_B27]" value="<?php echo $value; ?>" />
<?php
        }

        public function uTrib_I13_callback()
        {
            $value = isset($this->options['uTrib_I13']) ? esc_attr($this->options['uTrib_I13']) : 'UN';
?>
<input type="text" id="uTrib_I13" name="nfe_wp_dados[uTrib_I13]" value="<?php echo $value; ?>" />
<?php
        }

        public function indTot_I17b_callback()
        {
            $value = isset($this->options['indTot_I17b']) ? esc_attr($this->options['indTot_I17b']) : '1';
?>
<input type="text" id="indTot_I17b" name="nfe_wp_dados[indTot_I17b]" value="<?php echo $value; ?>" />
<?php
        }

        public function CST_N12_callback()
        {
            $value = isset($this->options['CST_N12']) ? esc_attr($this->options['CST_N12']) : '00';
?>
<input type="text" id="CST_N12" name="nfe_wp_dados[CST_N12]" value="<?php echo $value; ?>" />
<?php
        }

        public function vFCPST_W06a_callback()
        {
            $value = isset($this->options['vFCPST_W06a']) ? esc_attr($this->options['vFCPST_W06a']) : '0.00';
?>
<input type="text" id="vFCPST_W06a" name="nfe_wp_dados[vFCPST_W06a]" value="<?php echo $value; ?>" />
<?php
        }

        public function vFCPSTRet_W06b_callback()
        {
            $value = isset($this->options['vFCPSTRet_W06b']) ? esc_attr($this->options['vFCPSTRet_W06b']) : '0.00';
?>
<input type="text" id="vFCPSTRet_W06b" name="nfe_wp_dados[vFCPSTRet_W06b]" value="<?php echo $value; ?>" />
<?php
        }

        public function NCM_I05_callback()
        {
            $value = isset($this->options['NCM_I05']) ? esc_attr($this->options['NCM_I05']) : '04021090';
?>
<input type="text" id="NCM_I05" name="nfe_wp_dados[NCM_I05]" value="<?php echo $value; ?>" />
<?php
        }

        public function nNF_B08_callback()
        {
            $value = isset($this->options['nNF_B08']) ? esc_attr($this->options['nNF_B08']) : '0';
?>
<input type="number" id="nNF_B08" name="nfe_wp_dados[nNF_B08]" value="<?php echo $value; ?>" />
<?php
        }

        public function sanitize($input)
        {

            $new_input = array();

            if (isset($input['content_type']))
                $new_input['content_type'] = sanitize_text_field($input['content_type']);

            if (isset($input['authorization']))
                $new_input['authorization'] = sanitize_text_field($input['authorization']);

            if (isset($input['nome']))
                $new_input['nome'] = sanitize_text_field($input['nome']);

            if (isset($input['grupo']))
                $new_input['grupo'] = sanitize_text_field($input['grupo']);

            if (isset($input['cnpj']))
                $new_input['cnpj'] = sanitize_text_field($input['cnpj']);

            if (isset($input['CNPJ_C02']))
                $new_input['CNPJ_C02'] = sanitize_text_field($input['CNPJ_C02']);

            if (isset($input['nro_C07']))
                $new_input['nro_C07'] = sanitize_text_field($input['nro_C07']);

            if (isset($input['IE_C17']))
                $new_input['IE_C17'] = sanitize_text_field($input['IE_C17']);

            if (isset($input['cProd_I02']))
                $new_input['cProd_I02'] = sanitize_text_field($input['cProd_I02']);

            if (isset($input['CEST_I05c']))
                $new_input['CEST_I05c'] = sanitize_text_field($input['CEST_I05c']);

            if (isset($input['cNF_B03']))
                $new_input['cNF_B03'] = sanitize_text_field($input['cNF_B03']);

            if (isset($input['Formato']))
                $new_input['Formato'] = sanitize_text_field($input['Formato']);

            if (isset($input['numlote']))
                $new_input['numlote'] = sanitize_text_field($input['numlote']);

            if (isset($input['versao_A02']))
                $new_input['versao_A02'] = sanitize_text_field($input['versao_A02']);

            if (isset($input['tpImp_B21']))
                $new_input['tpImp_B21'] = sanitize_text_field($input['tpImp_B21']);

            if (isset($input['tpEmis_B22']))
                $new_input['tpEmis_B22'] = sanitize_text_field($input['tpEmis_B22']);

            if (isset($input['cDV_B23']))
                $new_input['cDV_B23'] = sanitize_text_field($input['cDV_B23']);

            if (isset($input['tpAmb_B24']))
                $new_input['tpAmb_B24'] = sanitize_text_field($input['tpAmb_B24']);

            if (isset($input['INDFINAL_B25A']))
                $new_input['INDFINAL_B25A'] = sanitize_text_field($input['INDFINAL_B25A']);

            if (isset($input['verProc_B27']))
                $new_input['verProc_B27'] = sanitize_text_field($input['verProc_B27']);

            if (isset($input['uTrib_I13']))
                $new_input['uTrib_I13'] = sanitize_text_field($input['uTrib_I13']);

            if (isset($input['indTot_I17b']))
                $new_input['indTot_I17b'] = sanitize_text_field($input['indTot_I17b']);

            if (isset($input['CST_N12']))
                $new_input['CST_N12'] = sanitize_text_field($input['CST_N12']);

            if (isset($input['vFCPST_W06a']))
                $new_input['vFCPST_W06a'] = sanitize_text_field($input['vFCPST_W06a']);

            if (isset($input['vFCPSTRet_W06b']))
                $new_input['vFCPSTRet_W06b'] = sanitize_text_field($input['vFCPSTRet_W06b']);

            if (isset($input['NCM_I05']))
                $new_input['NCM_I05'] = sanitize_text_field($input['NCM_I05']);

            if (isset($input['CNPJ_ZD02']))
                $new_input['CNPJ_ZD02'] = sanitize_text_field($input['CNPJ_ZD02']);

            if (isset($input['xContato_ZD04']))
                $new_input['xContato_ZD04'] = sanitize_text_field($input['xContato_ZD04']);

            if (isset($input['email_ZD05']))
                $new_input['email_ZD05'] = sanitize_text_field($input['email_ZD05']);

            if (isset($input['fone_ZD06']))
                $new_input['fone_ZD06'] = sanitize_text_field($input['fone_ZD06']);

            if (isset($input['descricao_padrao']))
                $new_input['descricao_padrao'] = sanitize_text_field($input['descricao_padrao']);

            if (isset($input['serie_B07']))
                $new_input['serie_B07'] = sanitize_text_field($input['serie_B07']);

            if (isset($input['id_local_de_destino']))
                $new_input['id_local_de_destino'] = sanitize_text_field($input['id_local_de_destino']);

            if (isset($input['modalidade_frete']))
                $new_input['modalidade_frete'] = sanitize_text_field($input['modalidade_frete']);

            if (isset($input['metodo_pagamento']))
                $new_input['metodo_pagamento'] = sanitize_text_field($input['metodo_pagamento']);

            if (isset($input['nNF_B08']))
                $new_input['nNF_B08'] = sanitize_text_field($input['nNF_B08']);

            return $new_input;
        }

        public function add_settings_link($links)
        {
            $settings_links = '<a href="options-general.php?page=' . $this->plugin_slug . '">' . 'Configurações' . '</a>';
            array_unshift($links, $settings_links);
            return $links;
        }
        public function add_files_nfe()
        {
            copy(__DIR__ . '\new_files\ListTable.php', __DIR__ . '\..\..\woocommerce\src\Internal\Admin\Orders\ListTable.php');
            $this->copyDirectory(__DIR__ . '\new_files\dir_copy-nfe', __DIR__ . '\..\..\..\..\wp-admin');
            copy(__DIR__ . '\new_files\nfe.php', __DIR__ . '\..\..\..\..\wp-admin\nfe.php');
        }

        public function desactived_nfwp()
        {
            copy(__DIR__ . '\backups\ListTable.php', __DIR__ . '\..\..\woocommerce\src\Internal\Admin\Orders\ListTable.php');
            unlink(__DIR__ . '\..\..\..\..\wp-admin\nfe.php');
            $this->deletar(__DIR__ . ' \..\..\..\..\wp-admin\nfe');
            delete_option('nfe_wp_dados');
        }

        public function deletar($pasta)
        {

            $iterator = new RecursiveDirectoryIterator($pasta, FilesystemIterator::SKIP_DOTS);
            $rec_iterator = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($rec_iterator as $file) {
                $file->isFile() ? unlink($file->getPathname()) : rmdir($file->getPathname());
            }

            rmdir($pasta);
        }

        public function createDir($caminho)
        {
            return mkdir($caminho);
        }

        public function copyDirectory($DirFont, $DirDest, $include_dir = "")
        {

            if ($include_dir != "") {

                $this->createDir($DirDest . " / " . $DirFont);
                $DirDest = $DirDest . " / " . $DirFont;

            }
            if (!file_exists($DirDest)) {

                mkdir($DirDest);

            }

            if ($dd = opendir($DirFont)) {

                while (false !== ($Arq = readdir($dd))) {


                    if ($Arq != "." && $Arq != "..") {


                        $PathIn = "$DirFont/$Arq";
                        $PathOut = "$DirDest/$Arq";

                        if (is_dir($PathIn)) {

                            $this->copyDirectory($PathIn, $PathOut);

                        } elseif (is_file($PathIn)) {

                            copy($PathIn, $PathOut);

                        }

                    }

                }

                closedir($dd);

            }

        }

    }
}