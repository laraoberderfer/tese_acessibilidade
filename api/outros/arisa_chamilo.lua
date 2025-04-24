res = callRest(
    'https://lara.arisa.com.br',
    '/api/chamilo.php',
    'POST',
    {
      'Accept: application/json'
    },
    null, null, null
)
print('Resultado ---\n', res)

out = callScript('gravar_log', 'user', 'chamilo', 'Buscando informacoes de Chamilo')
retorno = json.encode(res)
out = callScript('gravar_log', 'user', 'chamilo', 'Informacoes de Chamilo:'.. retorno)
out = callScript('gravar_log', 'user', 'chamilo', 'Enviando informacoes de Chamilo')