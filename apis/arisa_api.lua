--API chamada rest
callRest('https://lara.arisa.com.br','/api.php','GET', null, null, null, null)

-- print(res[1].usuario_id .. ': ' .. res[1].daltonico)
print('\nMOSTRAR TUDO -------------------------------\n')
print(res)
        







local log_file_path = "https://lara.arisa.com.br/logs/log.txt"

-- Função para gravar no arquivo de log
local function write_to_log(message)
    local log_file = io.open(log_file_path, "a") -- Abrir em modo de adição
    if log_file then
        log_file:write(os.date("%Y-%m-%d %H:%M:%S") .. " " .. message .. "\n")
        log_file:close()
    else
        print("Erro ao abrir o arquivo de log.")
    end
end

-- Registrar solicitação recebida
local usuario_id = "1"
write_to_log("[server@ISAP]: Recebendo solicitação para buscar dados de configuração de acessibilidade do " .. usuario_id)
write_to_log("[server@ISAP]: Buscando dados de configuração de acessibilidade do " .. usuario_id .. " no módulo de acessibilidade.")

res = json.decode(
  callRest(
    'https://lara.arisa.com.br',
    '/api.php',
    'GET',
    {
      'Accept: application/json'
    },
    null, null, null)
)

-- Registrar resposta recebida
write_to_log("[server@ISAP]: Recebendo o corpo de resposta de REST@Modulo_Acessibilidade.")
write_to_log("[server@ISAP]: Encaminando o corpo de resposta de REST@Modulo_Acessibilidade para " .. usuario_id .. "@Aplicacao.")


print(res[1].usuario_id .. ': ' .. res[1].daltonico)
print('\nMOSTRAR TUDO -------------------------------\n')
print(res)

