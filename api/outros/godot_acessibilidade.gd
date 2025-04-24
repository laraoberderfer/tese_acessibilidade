extends Control

@onready var http_request = $Button/HTTPRequest
@onready var rich_text_label = $RichTextLabel
var url = "https://lara.arisa.com.br/api.php"

# Função para gerar logs com data e hora
func log_message(tag: String, message: String) -> void:
    var timestamp = Time.get_time_string_from_system()  # Obtém a data e hora no formato do sistema
    print("%s Acessibilidade [%s]: %s" % [timestamp, tag, message])


# Chamado quando a solicitação HTTP é concluída
func _on_http_request_request_completed(result: int, response_code: int, headers: Array, body: PackedByteArray) -> void:
    log_message("main.ISAP-arisa", "Resultado da solicitação: %d" % result)
    log_message("main.ISAP-arisa", "Código de resposta HTTP: %d" % response_code)
    log_message("main.ISAP-arisa", "Cabeçalhos da resposta: %s" % str(headers))

    var body_string = body.get_string_from_utf8()
    log_message("main.ISAP-arisa", "Corpo da resposta: %s" % body_string)

    var json = JSON.new()
    var parse_result = json.parse(body_string)

    if parse_result != OK:
        log_message("main.ISAP-arisa", "Erro ao analisar JSON: %s" % body_string)
    else:
        var data = json.data
        log_message("main.server", "Dados carregados para a interface: %s" % str(data))
        _update_information(data)

# Atualiza as informações com os dados recebidos
func _update_information(data: Dictionary) -> void:
    if typeof(data) != TYPE_DICTIONARY:
        log_message("main.ISAP-arisa", "Erro: Dados recebidos não são um dicionário.")
        return

    log_message("main.ISAP-arisa", "Informações atualizadas com sucesso.")
    rich_text_label.text = str(data)

# Chamado quando o botão é pressionado
func _on_button_pressed() -> void:
    log_message("main.Server", "Iniciando solicitação para buscar dados de configuração de acessibilidade.")
    if http_request:
        log_message("main.Server", "Solicitando informações de acessibilidade...")
        http_request.request(url)
    else:
        log_message("main.Server", "Erro: HTTPRequest não está configurado corretamente.")
