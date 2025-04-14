<?php
require_once "conexao.php";

//Classe Produto

class Acessibilidade{
    //Atributos
    public $acessibilidade_id;
    public $usuario_id;
    public $pictograma;
    public $pictograma_tamanho;
    public $daltonico;
    public $protanopia;
    public $deuteranopia;
    public $tritanopia;
    public $legenda;
    public $legenda_velocidade;
    public $legenda_tamanho;
    public $legenda_cor;
    public $legenda_posicao;
    public $legenda_fundo;
    public $musica;
    public $musica_volume;
    public $efeitos_sonoros;
    public $efeitos_sonoros_volume;
    public $interprete;
    public $interprete_expressoes_faciais;
    public $interprete_gestos;
    public $interprete_audio;
    public $interprete_audio_velocidade;
    public $interprete_audio_volume;

    //Construtor
    function __construct($acessibilidade_id, $usuario_id, $pictograma, $pictograma_tamanho, $daltonico, $protanopia, $deuteranopia, $tritanopia, $legenda, $legenda_velocidade, $legenda_tamanho, $legenda_cor, $legenda_posicao, $legenda_fundo, $musica, $musica_volume, $efeitos_sonoros, $efeitos_sonoros_volume, $interprete, $interprete_expressoes_faciais, $interprete_gestos, $interprete_audio, $interprete_audio_velocidade, $interprete_audio_volume){
      $this->id = $acessibilidade_id;
      $this->usuario_id = $usuario_id;
      $this->pictograma = $pictograma;
      $this->pictograma_tamanho = $pictograma_tamanho;
      $this->daltonico = $daltonico;
      $this->protanopia = $protanopia;
      $this->deuteranopia = $deuteranopia;
      $this->tritanopia = $tritanopia;
      $this->legenda = $legenda;   
      $this->legenda_velocidade = $legenda_velocidade;
      $this->legenda_tamanho = $legenda_tamanho;
      $this->legenda_cor = $legenda_cor;
      $this->legenda_posicao = $legenda_posicao;
      $this->legenda_fundo = $legenda_fundo;
      $this->musica = $musica;
      $this->musica_volume = $musica_volume;
      $this->efeitos_sonoros = $efeitos_sonoros;
      $this->efeitos_sonoros_volume = $efeitos_sonoros_volume;
      $this->interprete = $interprete;
      $this->interprete_expressoes_faciais = $interprete_expressoes_faciais;
      $this->interprete_gestos = $interprete_gestos;
      $this->efeitos_sonoros_volume = $efeitos_sonoros_volume;
      $this->interprete_audio = $interprete_audio;
      $this->interprete_audio_velocidade = $interprete_audio_velocidade;
      $this->interprete_audio_volume = $interprete_audio_volume;
    }
    
    function get_id(){
      return $this->acessibilidade_id;
    }
    function get_usuario_id(){
      return $this->usuario_id;
    }
    function get_pictograma(){
      return $this->pictograma;
    }
    function get_pictograma_tamanho(){
        return $this->pictograma_tamanho;
    }
    function get_daltonico(){
        return $this->daltonico;
    }
    function get_protanopia(){
        return $this->protanopia;
    }
    function get_deuteranopia(){
        return $this->deuteranopia;
    }
    function get_tritanopia(){
        return $this->tritanopia;
    }
    function get_legenda(){
        return $this->legenda;
    }    
    function get_legenda_velocidade(){
        return $this->legenda_velocidade;
    }  
    function get_legenda_tamanho(){
        return $this->legenda_tamanho;
    }  
    function get_legenda_cor(){
        return $this->legenda_cor;
    } 
    function get_legenda_posicao(){
        return $this->legenda_posicao;
    }
    function get_legenda_fundo(){
        return $this->legenda_fundo;
    }
    function get_musica(){
        return $this->musica;
    }
    function get_musica_volume(){
        return $this->musica_volume;
    }
    function get_efeitos_sonoros(){
        return $this->efeitos_sonoros;
    }
    function get_efeitos_sonoros_volume(){
        return $this->efeitos_sonoros_volume;
    }
    function get_interprete(){
        return $this->interprete;
    }
    function get_interprete_expressoes_faciais(){
        return $this->interprete_expressoes_faciais;
    }
    function get_interprete_gestos(){
        return $this->interprete_gestos;
    }
    function get_interprete_audio(){
        return $this->interprete_audio;
    }
    function get_interprete_audio_velocidade(){
        return $this->interprete_audio_velocidade;
    }
    function get_interprete_audio_volume(){
        return $this->interprete_audio_volume;
    }
    
    // Método para buscar dados de acessibilidade
    public static function buscarDadosAcessibilidade($pdo, $usuario_id) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM acessibilidade WHERE usuario_id = :usuario_id");
            $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
            $dados = $stmt->fetch(PDO::FETCH_OBJ);

            if ($dados) {
                return new Acessibilidade(
                    $dados->acessibilidade_id,
                    $dados->usuario_id,
                    $dados->pictograma,
                    $dados->pictograma_tamanho,
                    $dados->daltonico,
                    $dados->protanopia,
                    $dados->deuteranopia,
                    $dados->tritanopia,
                    $dados->legenda,
                    $dados->legenda_velocidade,
                    $dados->legenda_tamanho,
                    $dados->legenda_cor,
                    $dados->legenda_posicao,
                    $dados->legenda_fundo,
                    $dados->musica,
                    $dados->musica_volume,
                    $dados->efeitos_sonoros,
                    $dados->efeitos_sonoros_volume,
                    $dados->interprete,
                    $dados->interprete_expressoes_faciais,
                    $dados->interprete_gestos,
                    $dados->interprete_audio,
                    $dados->interprete_audio_velocidade,
                    $dados->interprete_audio_volume
                );
            }
        } catch (PDOException $e) {
            die("Erro ao buscar dados de acessibilidade: " . $e->getMessage());
        }
        return null;
    }

    // Método para salvar dados de acessibilidade
    public static function salvarDadosAcessibilidade($pdo, $usuario_id, $dados) {
        try {
            /*echo '<pre>'; echo "Dados recebidos para salvar:\n";
            print_r($dados);
            echo "Usuário ID: $usuario_id\n";
            echo '</pre>';*/

            $stmt = $pdo->prepare("UPDATE acessibilidade SET 
                pictograma = :pictograma,
                pictograma_tamanho = :pictograma_tamanho,
                daltonico = :daltonico,
                protanopia = :protanopia,
                deuteranopia = :deuteranopia,
                tritanopia = :tritanopia,
                legenda = :legenda,
                legenda_velocidade = :legenda_velocidade,
                legenda_cor = :legenda_cor,
                legenda_tamanho = :legenda_tamanho,
                legenda_posicao = :legenda_posicao,
                legenda_fundo = :legenda_fundo,
                musica = :musica,
                musica_volume = :musica_volume,
                efeitos_sonoros = :efeitos_sonoros,
                efeitos_sonoros_volume = :efeitos_sonoros_volume,
                interprete = :interprete,
                interprete_expressoes_faciais = :interprete_expressoes_faciais,
                interprete_gestos = :interprete_gestos,
                interprete_audio = :interprete_audio,
                interprete_audio_velocidade = :interprete_audio_velocidade,
                interprete_audio_volume = :interprete_audio_volume
                WHERE usuario_id = :usuario_id");

            foreach ($dados as $key => $value) {
                // Lista de campos que são VARCHAR no banco de dados
                $camposVarchar = ['legenda_cor', 'legenda_fundo'];
                // Verificar se o campo é VARCHAR
                if (in_array($key, $camposVarchar)) {
                    $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue(":$key", $value, is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }
            }
            $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao salvar dados de acessibilidade: " . $e->getMessage());
        }
    }
    
    /**
     * Método para verificar se um valor de checkbox está selecionado
     * @param mixed $valor O valor do campo (1 para selecionado, 0 ou null para não selecionado)
     * @return string Retorna 'checked' se o valor for 1, caso contrário, retorna uma string vazia
     */
    public static function isChecked($valor) {
        return $valor == 1 ? 'checked' : '';
    }
}
?>