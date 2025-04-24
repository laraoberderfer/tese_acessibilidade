api_key = "lkawjflkajsl"
date = os.date("%Y/%m/%d %H:%M:%S")
user = args[1]
app = args[2]
text = args[3]

out = callRest(
  'https://lara.arisa.com.br',
  '/api/logs.php',
  'POST',
  {
    'Content-Type: application/json',
    'Accept: application/json'
  },
  json.encode({
      API_KEY = api_key,
      app = app,
      date = date,
      user = user,
      text = text
    }),
  null, null, null
)

return out
