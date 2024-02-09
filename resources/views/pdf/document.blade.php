<!DOCTYPE html>
<html>
<head>
    <title>Documento</title>
    <style>
        /* Adicione aqui qualquer estilo CSS que você queira aplicar ao seu PDF */
    </style>
</head>
<body>
    <h1>{{ $nome }}</h1>
    @foreach ($dates as $date)
      <p>Data: {{ $date }}</p>
    @endforeach
    <p>{{ $conteudo }}</p>
</body>
</html>