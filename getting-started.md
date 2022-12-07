---
title: "howToUse"
slug: "getting-started"
excerpt: "Está página irá lhe auxiliar como testar o script de verificação da força de senhas."
hidden: false
createdAt: "2022-12-07T11:22:50.815Z"
updatedAt: "2022-12-07T15:55:54.570Z"
---
Bem vindo! 

Nos tópicos a seguir você recebera instruções de quais os pacotes e instalações necessárias para rodar o programa e como realizar uma requisição para a API do projeto. 

## 🗯 Info

O projeto foi desenvolvido da seguinte forma: API foi desenvolvida em Python com Django REST Framework e as funcionalidades da validação de senha em PHP.

# 💻 Instalação do PHP

#### Windows 

[PHP 8.1 para Windows](https://windows.php.net/download#php-8.1)

> Certifique-se de adicionar o PHP para o PATH do Windows.

#### Linux

Siga o passo-a-passo:

[PHP 8.1 para Linux](https://www.scriptcase.com.br/docs/pt_br/v9/manual/02-instalacao-scriptcase/06-linux_php/)

#### MacOS

Siga o passo-a-passo:

[PHP 8.1 para MAC](https://www.scriptcase.com.br/docs/pt_br/v9/manual/02-instalacao-scriptcase/07-mac_php/)

# 💻 Instalação do Python

Procure a versão mais recente do Python e instale a que for compatível ao seu sistema operacional.

[Python](https://www.python.org/)

> Em caso de erro na execução, tente instalar a versão 3.11.0 que foi a mesma utilizada no desenvolvimento.

### PIP

Assim que estiver instalado o Python tente executar o seguinte comando na linha de comando(CMD, Console) do seu sistema operacional.

```
pip --version
```



Assim você certificara que o **pip** foi instalado juntamente com a instalação do **Python**. Caso o sistema operacional não reconheça o comando tente instalar manualmente.

#### Windows

[Instalação manual ](https://www.geeksforgeeks.org/how-to-install-pip-on-windows/#:~:text=Method%202%3A%20Manually%20install%20PIP%20on%20Windows)

#### Linux

[Instalação manual Linux](https://www.tecmint.com/install-pip-in-linux/)

#### MacOS

[Instalação manual MacOS](https://www.groovypost.com/howto/install-pip-on-a-mac/#:~:text=To%20install%20PIP%20using,m%20ensurepip%20%E2%80%93upgrade%20instead)

# 💻 Instalação do Django

#### Windows

```
py -m pip install Django
```



#### Linux/MacOS

```
$ python -m pip install Django
```

# 🖥Instalação do Django REST Framework

```
pip install djangorestframework
```

### Django CORS Headers

Uma aplicação do Django que adiciona cabeçalhos de compartilhamento de recursos entre origens (CORS) às respostas. Isso permite solicitações no navegador para seu aplicativo Django de outras origens.

# Utilização

## 📃❓ Utilização da API para novas requisições

### 🔛 Iniciar servidor da API

Inicie uma linha de comando (CMD, Console) dentro da seguinte pasta:

![](https://files.readme.io/7731535-image.png)

Rode o seguinte comando dentro da pasta especifica:

 

```
python manage.py runserver
```

O retorno deve ser algo como:

![](https://files.readme.io/3522f32-image.png)

> 👍 Agora você está pronto para enviar uma requisição a API.

### Requisição para API

Para testar e utilizar as requisições na API REST foi utilizado o [ReqBin](https://reqbin.com/), site para requisições para APIs WEB.

![](https://files.readme.io/a8cf415-image.png)

Certifique-se de colocar a rota correta da API para onde a requisição será enviada:

```
http://localhost:8000/verify/
```

#### Extensão do ReqBin

> 🚧 Você irá precisar!
> 
> Será necessário instalar a seguinte extensão no navegador para que a requisição chegue até a API e seja processada com sucesso. Você poderá instalar a extensão na [Loja de extensões do Chrome](https://chrome.google.com/webstore/detail/reqbin-http-client/gmmkjpcadciiokjpikmkkmapphbmdjok).

***

A API foi configurada para apenas receber métodos GET e **POST**, onde neste modelo de projeto será utilizada apenas o **POST**.

***

Não é necessário utilizar nenhum token de autorização para mandar requisições para a API.

### Modelo correto do JSON para requisição

![](https://files.readme.io/7f85fe9-image.png)

O campo "password" é o campo referente a senha a ser validada. Enquanto o campo "rules" é um array de regras para serem verificadas, podendo ser passadas todas regras disponíveis: - ou nenhuma.

```
"minSize"
"minUppercase"
"minLowercase"
"minDigit"
"minSpecialChars"
"noRepeted"
```

Cada regra tem o campo _**"rule"**_ e _**"value"**_. Onde o campo valor é referente a quantidade de vezes que será necessário cumprir tal regra para a senha ser validada.

## ⌨ Execução do script

Com o projeto extraído você deve ter o seguinte esquema de arquivos e pastas:

![](https://files.readme.io/828f331-image.png)

O Script de validação de senha funciona da seguinte forma:

1. API recebe uma requisição nova de POST com o padrão já apresentado em seções anteriores deste documento.
2. Você executa o arquivo main.php que irá pegar a última requisição enviada para a API e retornar um JSON validando ou não a senha, com base nos parâmetros estabelecidos.

![](https://files.readme.io/7e5fe34-image.png)

2. 1.  Dependendo do formatado de execução do código o resultado pode ser visualizado das seguintes formas:

[block:image]
{
  "images": [
    {
      "image": [
        "https://files.readme.io/590e1a8-image.png",
        null,
        null
      ],
      "border": true,
      "caption": "Este rodando num servidor PHP local."
    }
  ]
}
[/block]



[block:image]
{
  "images": [
    {
      "image": [
        "https://files.readme.io/c8a73e4-image.png",
        null,
        null
      ],
      "sizing": "700px",
      "caption": "Este rodando na compilador PHP na linha de comando."
    }
  ]
}
[/block]

## Lógica de Implementação

#### Resgate do dados da API

O arquivo CurlConnection.php é responsavel por inicializar uma sessão cURL que irá retornar o _data_ da URL informada, no caso, um JSON da verificação de senha.

```php
function connect($url) {
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    return $curl;
}
```



#### Validação da senha

O arquivo checkers.php é onde está todas as funções que validam as regra em cima da senha solicitada. 

```php
function getCurrentRule($requestData,string $rule)
{
    $currentRule = '';
    $ruleValue = [];

    for ($i = 0; $i < count($requestData["rules"]); $i++) {
        $currentRule = $requestData["rules"][$i]["rule"];
        if ($currentRule == $rule){
            $ruleValue = ['value' =>$requestData["rules"][$i]["value"]];
            break;
        }
    }

    return $ruleValue;
}
```

O código acima é responsável por carregar cada regra em seu devido momento, tendo em vista que as regras são passadas em um _Array_ e cada uma vai sendo verificado por vez independente da ordem.

```php
function countUpperCases(string $string) 
{
    $upperCases = preg_match_all("/[A-Z]/", $string);

    return $upperCases;
}

function countLowerCases(string $string)
{
    $lowerCases = preg_match_all("/[a-z]/", $string);

    return $lowerCases;
}

function countDigits(string $string)
{
    $digits = preg_match_all("/[0-9]/", $string);

    return $digits;
}

function countSpecialCharacters(string $string)
{
    $specialChars = preg_match_all("/\W/", $string);

    return $specialChars;
}

function noRepeted(string $string)
{
    $repetitions = preg_match_all('/([a-zA-Z])\1+/', $string);

    return $repetitions;
}
```

As funções acima são os _validators_ específicos de cada regra.

```php
function verifyPasswordStrength($requestData)
{
    $noMatchingRules = [];
    
    $rules = '';
    for ($i = 0; $i < count($requestData["rules"]); $i++) {
        $rules .= $requestData["rules"][$i]["rule"].',';
    }
    
    if ((strripos($rules,'minSize') >= 0) && (strripos($rules,'minSize') !== false)) {
        $ruleValue = getCurrentRule($requestData, 'minSize');

        if (strlen($requestData["password"]) < $ruleValue["value"]) {
            $noMatchingRules[] = 'minSize';
        }
    }

    if ((strripos($rules,'minUppercase') >= 0) && (strripos($rules,'minUppercase') !== false)) {
        $ruleValue = getCurrentRule($requestData, 'minUppercase');

        if (countUpperCases($requestData["password"]) < $ruleValue["value"]) {
            $noMatchingRules[] = 'minUppercase';
        }
    }

    if ((strripos($rules,'minLowercase') >= 0) && (strripos($rules,'minLowercase') !== false)) {
        $ruleValue = getCurrentRule($requestData, 'minLowercase');

        if (countLowerCases($requestData["password"]) < $ruleValue["value"]) {
            $noMatchingRules[] = 'minLowercase';
        }
    }

    if ((strripos($rules,'minDigit') >= 0) && (strripos($rules,'minDigit') !== false)) {
        $ruleValue = getCurrentRule($requestData, 'minDigit');

        if (countDigits($requestData["password"]) < $ruleValue["value"]) {
            $noMatchingRules[] = 'minDigit';
        }
    }

    if ((strripos($rules,'minSpecialChars') >= 0) && (strripos($rules,'minSpecialChars') !== false)) {
        $ruleValue = getCurrentRule($requestData, 'minSpecialChars');

        if (countSpecialCharacters($requestData["password"]) < $ruleValue["value"]) {
            $noMatchingRules[] = 'minSpecialChars';
        }
    }

    if ((strripos($rules,'noRepeted') >= 0) && (strripos($rules,'noRepeted') !== false)) {
        $ruleValue = getCurrentRule($requestData, 'noRepeted');

        if (noRepeted($requestData["password"]) > 0) {
            $noMatchingRules[] = 'noRepeted';
        }
    }

    return $noMatchingRules;
}
```

A função verifyPasswordStrength faz uso das funções _validators_ anteriormente citadas e armazena as regras em que a senha não conseguiu atender ao requisitos mínimos.

```php
function validateRequest($noMatchingRules)
{
    if (count($noMatchingRules) > 0) {
        $resultArray = array('verify' => false, 'noMatch' => $noMatchingRules);

        return json_encode($resultArray);
    } else {
        $resultArray = array('verify' => true, 'noMatch' => []);

        return json_encode($resultArray);
    }
}
```

A função validateRequest verifica se o array passado por parâmetro possui pelo menos uma regra em que a senha não 'passou', se o resultado for verdadeiro ele retorna um JSON com dois campos _**verify**_ e _**noMatch**_. 

```php
include_once 'curlConnection.php';
include_once 'checkers.php';

$curl = connect('http://localhost:8000/verify/');

$requestResult = json_decode(curl_exec($curl), true);

$noMatchingRules = verifyPasswordStrength(end($requestResult));

echo validateRequest($noMatchingRules);
```

O arquivo acima é o main.php responsável por chamar a conexão do cURL e passar a _Request_ de verificação correspondente para as funções de checkers.php e retornar o JSON de resultado.
