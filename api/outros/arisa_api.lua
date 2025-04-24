res = json.decode(
  callRest(
    'https://lara.arisa.com.br',
    '/api/acessibility.php',
    'GET',
    {
      'Accept: application/json'
    },
    null, null, null)
)
out = callScript('gravar_log', 'user', 'ArisaNest', 'Buscando informacoes de configuracao de acessibilidade')
print(out)
print(res[1].usuario_id .. ': ' .. res[1].daltonico)
print('\nResultado -------------------------------\n')
print(res)
retorno = json.encode(res)
out = callScript('gravar_log', 'user', 'ArisaNest', 'Informacoes de configuracao de acessibilidade:'.. retorno)
out = callScript('gravar_log', 'user', 'ArisaNest', 'Enviando informacoes de configuracao de acessibilidade')