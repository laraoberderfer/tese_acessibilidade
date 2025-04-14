<?php
// Função para verificar se os dados do formulário login
function verificarFormularioIndex() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['senha'])) {
        return [
            'email' => $_POST['email'],
            'senha' => $_POST['senha']
        ];
    }
    return null;
}
?>