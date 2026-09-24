<?php
session_start();
require '../../includes/conexao.php';
require '../../includes/verificar_sessao.php';

verificar_perfil('Coordenação');

$id_coordenador = $_SESSION['id_usuario'];

// Buscar dados do coordenador
$sql = "SELECT * FROM usuario WHERE id_usuario = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_coordenador);
$stmt->execute();
$result = $stmt->get_result();
$coordenador = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordenação | Cadastro</title>
    <style>*{box-sizing:border-box}body{margin:0;background:#f7f8fd;color:#20283e;font-family:Inter,Arial,sans-serif}main{max-width:1230px;margin:0 auto;padding:34px 32px 65px}.topo,.header{background:#fff;color:#20283e;border:1px solid #e2e5f1;border-radius:18px;padding:28px 30px;margin-bottom:22px}.topo:before,.header:before{content:"COORDENAÇÃO · PORTAL ACADÊMICO";display:block;color:#6353c7;letter-spacing:1.4px;font-size:11px;font-weight:800;margin-bottom:10px}.topo h1,.header h1{font-size:28px;letter-spacing:-.8px;margin:0}.box,.panel{background:#fff;border:1px solid #e2e5f1;border-radius:18px;padding:26px;margin-bottom:20px;box-shadow:0 5px 20px rgba(20,25,65,.025)}.panel h2{font-size:19px;margin:0 0 18px;color:#20283e}.formulario{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:17px}.campo{display:flex;flex-direction:column;gap:7px;min-width:0}.campo.full{grid-column:1/-1}label,.msg-label{display:block;font-weight:650;color:#404960;font-size:13px;margin:0 0 7px}input,select,textarea,.msg-input,.msg-select,.msg-textarea{width:100%;min-width:0;background:#fff;border:1px solid #dce0ed;border-radius:10px;padding:12px 13px;font:inherit;font-size:14px;color:#25304a;outline:none}input:focus,select:focus,textarea:focus{border-color:#6554ce;box-shadow:0 0 0 3px #6554ce18}input:disabled,select:disabled{background:#f7f8fc;color:#505b73;opacity:1}.msg-label{margin-top:17px}.msg-textarea{min-height:120px;resize:vertical}.btn-enviar,.principal{background:#6150c9;color:white;border:0;border-radius:10px;padding:12px 20px;font:inherit;font-size:14px;font-weight:700;cursor:pointer;margin-top:18px}.btn-enviar:hover,.principal:hover{background:#5140b6}.secundario{background:#f0edff;color:#5746bf;border:0;border-radius:10px;padding:12px 18px}.panel table{width:100%;border-collapse:collapse;font-size:14px}.panel th{text-align:left;font-size:11px;letter-spacing:.6px;text-transform:uppercase;color:#66718a;background:#f8f9fd;padding:14px 12px}.panel td{border-bottom:1px solid #eceef5;padding:15px 12px}.panel tr:last-child td{border-bottom:0}.assunto,a{color:#5947c4}.assunto{font-weight:650;text-decoration:none}.assunto:hover,a:hover{text-decoration:underline}.badge{display:inline-flex;padding:5px 10px;border-radius:8px;font-size:12px;font-weight:700}.verde{background:#eaf7f0;color:#24764c}.vermelho{background:#fff0e7;color:#ad5b21}.msg-header{border-bottom:1px solid #e9ebf3;padding-bottom:16px;margin-bottom:20px}.msg-header p{color:#566078;margin:8px 0;font-size:14px}.msg-content{line-height:1.8;white-space:normal;overflow-wrap:anywhere}.panel form{max-width:760px}.panel:has(table){overflow-x:auto}@media(max-width:760px){main{padding:22px 15px 40px}.topo,.header,.box,.panel{padding:21px}.topo h1,.header h1{font-size:24px}.formulario{grid-template-columns:1fr}.panel table{min-width:580px}}</style>
</head>
<body>
    <?php include "../../includes/menu_coordenacao.php"; ?>

    <main>
        <section class="topo">
            <h1>Meu Perfil</h1>
        </section>

        <section class="box">
            <div style="background: #edf5ff; color: #17477c; padding: 10px; border-radius: 5px; margin-bottom: 15px;">Este cadastro é somente para consulta.</div>
            <div class="formulario">
                <div class="campo">
                    <label for="perfil">Perfil</label>
                    <select id="perfil" disabled>
                        <option><?php echo htmlspecialchars($coordenador['perfil'] ?? 'Coordenação'); ?></option>
                    </select>
                </div>

                <div class="campo">
                    <label for="nome">Nome completo</label>
                    <input id="nome" type="text" value="<?php echo htmlspecialchars($coordenador['nome'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="cpf">CPF</label>
                    <input id="cpf" type="text" value="<?php echo htmlspecialchars($coordenador['cpf'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="rg">RG</label>
                    <input id="rg" type="text" value="<?php echo htmlspecialchars($coordenador['rg'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="nascimento">Data de nascimento</label>
                    <input id="nascimento" type="date" value="<?php echo htmlspecialchars($coordenador['data_nascimento'] ?? ''); ?>" disabled />
                </div>

                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input id="telefone" type="text" value="<?php echo htmlspecialchars($coordenador['telefone'] ?? ''); ?>" disabled />
                </div>

                <div class="campo full">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" value="<?php echo htmlspecialchars($coordenador['email'] ?? ''); ?>" disabled />
                </div>

                <div class="campo full">
                    <label for="endereco">Endereço</label>
                    <input id="endereco" type="text" value="<?php echo htmlspecialchars($coordenador['endereco'] ?? ''); ?>" disabled />
                </div>

            </div>
        </section>
    </main>
</body>
</html>
