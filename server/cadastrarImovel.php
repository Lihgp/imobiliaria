<?php

require "connection/conexao.php";

$conn = conectaBanco();

$categoria = $finalidade = $numQuarto = $numSuite = $descricao = $area = $piscina = $andar = $vlrCondominio = $numApto = $codProprietario = $bairro = $vlrImovel = "";

try {
    if (!isset($_POST["categoriaImovel"]))
        throw new Exception("A categoria do imóvel deve ser fornecida.");
    if (!isset($_POST["finalidade"]))
        throw new Exception("A finalidade do imóvel deve ser fornecida.");
    if (!isset($_POST["qtdQuartos"]))
        throw new Exception("A quantidade de quartos do imóvel deve ser fornecida.");
    if (!isset($_POST["qtdSuites"]))
        throw new Exception("A quantidade de suítes do imóvel deve ser fornecida.");
    if ($_POST["categoriaImovel"] === "casa") {
        if (!isset($_POST["area"]))
            throw new Exception("A área do imóvel deve ser fornecida.");
    } else {
        if (!isset($_POST["andar"]))
            throw new Exception("O andar do imóvel deve ser fornecido.");
        if (!isset($_POST["vlrCondominio"]))
            throw new Exception("O valor do condomínio do imóvel deve ser fornecido.");
        if (!isset($_POST["numApto"]))
            throw new Exception("O número do apartamento do imóvel deve ser fornecido.");
    }
    if (!isset($_POST["proprietario"]))
        throw new Exception("O proprietário do imóvel deve ser fornecido.");
    if (!isset($_POST["bairro"]))
        throw new Exception("O bairro do imóvel deve ser fornecido.");
    if (!isset($_POST["vlrImovel"]))
        throw new Exception("O valor do imóvel deve ser fornecido.");
    
    
    $categoria = filtraEntradaForm($_POST["categoriaImovel"]);
    $finalidade = filtraEntradaForm($_POST["finalidade"]);
    $numQuarto = filtraEntradaForm($_POST["qtdQuartos"]);
    $numSuite = filtraEntradaForm($_POST["qtdSuites"]);
    $descricao = filtraEntradaForm($_POST["descricao"]);
    if ($categoria === "casa") {
        $area = formataDataSalvarBanco(filtraEntradaForm($_POST["area"]));
        $piscina = filtraEntradaForm($_POST["piscina"]);
    } else {
        $andar = converteDecimalSalvarBanco(filtraEntradaForm($_POST["andar"]));
        $vlrCondominio = converteDecimalSalvarBanco(filtraEntradaForm($_POST["vlrCondominio"]));
        $numApto = filtraEntradaForm($_POST["numApto"]);
    }
    $codProprietario = filtraEntradaForm($_POST["proprietario"]);
    $bairro = filtraEntradaForm($_POST["bairro"]);
    $vlrImovel = converteDecimalSalvarBanco(filtraEntradaForm($_POST["vlrImovel"]));
    
    if ($categoria == "")
        throw new Exception("A categoria do imóvel deve ser fornecida.");
    if ($finalidade == "")
        throw new Exception("A finalidade do imóvel deve ser fornecida.");
    if ($numQuarto == "")
        throw new Exception("A quantidade de quartos do imóvel deve ser fornecida.");
    if ($numSuite == "")
        throw new Exception("A quantidade de suítes do imóvel deve ser fornecida.");
    if ($categoria === "casa") {
        if ($area == "")
        throw new Exception("A área do imóvel deve ser fornecida.");
    } else {
        if ($andar === "")
            throw new Exception("O andar do imóvel deve ser fornecido.");
        if ($vlrCondominio === "")
            throw new Exception("O valor do condomínio do imóvel deve ser fornecido.");
        if ($numApto === "")
            throw new Exception("O número do apartamento do imóvel deve ser fornecido.");
    }
    if ($codProprietario === "")
        throw new Exception("O proprietário do imóvel deve ser fornecido.");
    if ($bairro === "")
        throw new Exception("O bairro do imóvel deve ser fornecido.");
    if ($vlrImovel === "")
        throw new Exception("O valor do imóvel deve ser fornecido.");
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

try 
{
    $conn->begin_transaction();

    $codImovel = cadastrarImovel($finalidade, $numQuarto, $numSuite, $codProprietario, $bairro, $vlrImovel, $descricao, $conn);
    if ($categoria === "casa") {
        cadastrarImovelCasa($codImovel, $area, $piscina, $conn);
    } else {
        cadastrarImovelApto($codImovel, $andar, $vlrCondominio, $numApto, $conn);
    }
    echo "OK";
    $conn->commit();
    $conn->close();

} catch (Exception $e){
    $conn->rollback();
    $conn->close();
    http_response_code(400);
    throw new Exception($e);
}

function cadastrarImovelCasa($codImovel, $area, $piscina, $conn)  {
    $sqlCadastrarImovelCasa = "INSERT INTO imovelcasa(codImovel , areaTerreno, piscina ) VALUES (?, ?, ?)";

    try {
        if (!$stmt = $conn->prepare($sqlCadastrarImovelCasa))
            throw new Exception("Falha na operacao prepare: " . $conn->error);
    
        if (!$stmt->bind_param("idi", $codImovel, $area, $piscina))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);
            
        if (!$result = $stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}

function cadastrarImovelApto($codImovel, $andar, $vlrCondominio, $numApto, $conn)  {
    $sqlCadastrarImovelApto = "INSERT INTO imovelapto(codImovel , numApto, andar, vlrCondominio ) VALUES (?, ?, ?, ?)";

    try {
        if (!$stmt = $conn->prepare($sqlCadastrarImovelApto))
            throw new Exception("Falha na operacao prepare: " . $conn->error);
    
        if (!$stmt->bind_param("isid", $codImovel, $numApto, $andar, $vlrCondominio))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);
        
        if (!$result = $stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);    
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}

function cadastrarImovel($finalidade, $numQuarto, $numSuite, $codProprietario, $bairro, $vlrImovel, $descricao, $conn) {

    $nomeImagem = salvarArquivos();

    
//     if(!file_exists("../imagens")):  
//         mkdir("../imagens");  
//    endif;  
//     $pasta = "../imagens/" . $_FILES["image"]["name"][0];
//     // move_uploaded_file( $_FILES["image"]["name"][0], $pasta );
//     // $ftp->upload($_FILES["image"]["name"][0], $pasta);
//     if (!move_uploaded_file($_FILES['image']['tmp_name'][0], $pasta)):  
//         $retorno = array('status' => 0, 'mensagem' => 'Houve um erro ao gravar arquivo na pasta de destino!');       
//         throw new Exception("ASASASsasasasAsASAasSAASA" . $_FILES['image']['tmp_name'][0]) ;
//         exit();  
//    endif; 
//     throw new Exception("AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA" .$pasta) ;

    $sqlCadastrarImovel = "INSERT INTO imovel(codProprietario, finalidade, valorImovel, bairro, numQuarto, numSuite, descricao)
        VALUES ( ?, ?, ?, ?, ?, ?, ?)";

    try {
        if (!$stmt = $conn->prepare($sqlCadastrarImovel))
            throw new Exception("Falha na operacao prepare: " . $conn->error);
    
        if (!$stmt->bind_param("isdsiis", $codProprietario, $finalidade, $vlrImovel, $bairro, $numQuarto, $numSuite, $descricao))
            throw new Exception("Falha na operacao bind_param: " . $stmt->error);
    
        if (!$stmt->execute())
            throw new Exception("Falha na operacao execute: " . $stmt->error);
        
        return $conn->insert_id;
    } catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }
}

function salvarArquivos () {
    $diretorioBase = "../imagens";
    if(!file_exists($diretorioBase)):  
        mkdir($diretorioBase);
    
        foreach ($_FILES["image"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["image"]["tmp_name"][$key];
                $name = $_FILES["image"]["name"][$key];
                $arquivo = '/diretorio/arquivo.txt';
                if (file_exists($arquivo)) {
                    echo "O arquivo $arquivo existe";
                } else {
                    echo "O arquivo $arquivo não existe";
                }
                move_uploaded_file($tmp_name, "../imagens/$name");
            }
        }
    $pasta = "../imagens/" . $_FILES["image"]["name"][0];
    // move_uploaded_file( $_FILES["image"]["name"][0], $pasta );
    // $ftp->upload($_FILES["image"]["name"][0], $pasta);
    if (!move_uploaded_file($_FILES['image']['tmp_name'][0], $pasta)):  
        $retorno = array('status' => 0, 'mensagem' => 'Houve um erro ao gravar arquivo na pasta de destino!');       
        throw new Exception("ASASASsasasasAsASAasSAASA" . $_FILES['image']['tmp_name'][0]) ;
        exit();  
   endif; 
    throw new Exception("AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA" .$pasta) ;
}

function filtraEntradaForm($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function converteDecimalSalvarBanco($valor) {
    if ($valor == "") return 0;
    else {
        $valor = str_replace(".","", $valor);
        $valor = str_replace(",",".", $valor);
        $valor = floatval($valor);
    }
    return $valor;
}

?>