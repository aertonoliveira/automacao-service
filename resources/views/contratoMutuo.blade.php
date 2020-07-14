<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <style>
        .full-height{
            line-height: 20px;
        }
    </style>

</head>
<body>
<div class="flex-center position-ref full-height">

    <b>CONTRATO DE PARTICIPAÇÃO DE INVESTIDOR</b>
    <br><br><br>
    <b>JIN INVEST MONEY EIRELI</b>
    <br><br><br>
    _____ de ____________ de______
    <br><br><br>
    <b><u>I-DO OBJETO</u></b>
    <br>
    Cláusula primeira - O objeto do presente contrato é o investimento para o fomento à inovação e incentivo à produção, considerando que os Sócios são titulares e possuidores legítimos de 100% (cem por cento) do capital social da Sociedade. O Investidor realizará um aporte especial de capital, nos termos do artigo 61-A da Lei Complementar n° 123/2006.
    <br><br>
    Cláusula segunda - Pelo presente instrumento, RESOLVEM as Partes, celebrar o presente, que se regerá pelas disposições e condições a seguir enumeradas.
    <br><br>
    <b><u>II- IDENTIFICAÇÃO DAS PARTES</u></b>
    <br>
    Cláusula terceira - Para todos os efeitos jurídicos, ficam identificadas as Partes:
    <br><br>
    Se Pessoa Física:
    <br><br>

    {{$contrato->user->name}}, Brasileiro,   {{$contrato->user->estado_civil}}, {{$contrato->user->profissao}}, residente e domiciliado na {{$contrato->user->rua}},{{$contrato->user->numero}},{{$contrato->user->complemento}}, {{$contrato->user->bairro}}, {{$contrato->user->cidade}}, Estado de {{$contrato->user->estado}}, portador da cédula de identidade RG n° {{$contrato->user->rg}}; e, de outro lado:
    <br><br><br>
    JIN APLICACOES FINANCEIRAS EIRELI, sociedade com sede na AV DR JOSE MACHADO DE SOUZA , 120, SALA 1508 COND HORIZONTE JARDINS OF , JARDINS , ARACAJU , Estado de SE, inscrita no CNPJ/MF sob o n° 18.359.495/0001-05 JIN INVEST MONEY; e, ainda, como intervenientes anuentes:
    <br><br><br>
    <b><u>III- DEFINIÇÕES</u></b>
    <br>
    Cláusula quarta - As palavras abaixo, quando utilizadas no singular ou plural, sem prejuízo de outras definições atribuídas nas Cláusulas deste Contrato, terão os seguintes significados:
    <br><br>
    (A) - Aporte: R$ {{$contrato->valor}}
    <br><br>
    (B) - Percentual de Referência para o rendimentos: {{$contrato->porcentagem}}%.
    <br><br>
    (C) - Prazo Máximo para Resgate: {{\Carbon\Carbon::parse( $contrato->inicio_mes)->format('d/m/Y')}} / {{ \Carbon\Carbon::parse( $contrato->final_mes)->format('d/m/Y')  }} / {{ \Carbon\Carbon::parse( $contrato->final_mes)->format('Y')  }} . (Deverá ser de até sete anos contados da data de assinatura do contrato, conforme Lei Complementar n° 123/2006, art. 61-A, § 1°)
    A contratada disponibiliza a plataforma de pagamentos de benefícios, como conta digital de pontos e cartão pré-pago, sendo que toda e qualquer tarifa da plataforma ocorrerá por conta do Credor.
    <br><br>
    <b><u>IV- DO PRAZO</u></b>
    <br>
    Cláusula quinta - Para incentivar as atividades de inovação e os incentivos à produção, objeto desde contrato, nos termos do Artigo 61-A da Lei Complementar n° 123/2006, a Sociedade receberá o aporte de capital, que não integrará o seu capital social, ficando estabelecido o prazo máximo de sete (sete) anos de vigência, a contar a partir de sua assinatura.
    <br>
    O INVESTIDOR declara que o preenchimento e a assinatura deste instrumento não garantem o deferimento da operação pela <b>JIN INVEST MONEY EIRELI</b> que irá ainda processar, e verificar o depósito em conta ou pagamento do boleto dos demais requisitos que o levará a decisão quanto à contratação.
    <br>
    Somente começa os a partir do <b>5 dia util</b> apos a compensado a importancia, sendo que o pagamento dos rendimentos se dará no <b>12° (décimo segundo)  dia util</b> do mes posterior a contratação.
    <br>
    O regate do capital investido ocorrerá somente 45 dias após o vencimento do contrato, nos termos do item III, alínea “C”.
    <br><br>
    <b><u>V-DO INVESTIMENTO</u></b>
    <br>
    Cláusula sexta - O Investidor não será considerado sócio nem terá qualquer direito a gerência ou voto na administração da Sociedade, bem como não responderá por qualquer dívida da empresa, inclusive em recuperação judicial, não se aplicando ao Investidor o artigo 50 do Código Civil.
    <br><br>
    § 1°- O Investidor não se manifestando sobre o Resgate dentro do Prazo Máximo estipulado, caberá a Sociedade, independentemente de qualquer Notificação de Resgate, realizar o pagamento do Resgate ao Investidor, nos termos estabelecidos neste contrato.
    <br><br>
    § 2°- A <b>JIN INVEST MONEY EIRELI disponibiliza</b> a plataforma de pagamentos de benefícios, como conta digital de pontos e cartão pré-pago. que
    <br><br>
    Cláusula oitava - O resgate poderá ser realizado imediatamente pelo Investidor, em caso de ocorrência de descumprimento, insuficiência, falsidade e incorreção de qualquer das obrigações assumidas pela Sociedade e/ou pelos Sócios neste Contrato, sem prejuízo do Investidor ser indenizado por quaisquer perdas e danos decorrentes da violação dessas obrigações.
    <br><br>
    Cláusula nona - Na hipótese de término da Sociedade em decorrência de pedido de falência ou autofalência, decretação de falência, pedido de recuperação judicial ou extrajudicial, ou, ainda, qualquer procedimento judicial análogo, inclusive dissolução e/ou liquidação da Sociedade pelo evento de “Término da Sociedade”, a Sociedade deverá realizar o pagamento do Aporte ao Investidor, até a Data de Vencimento, com a maior prioridade em relação a outros débitos que a Sociedade possa ter na data do Evento de Término da Sociedade.
    <br><br>
    <b><u>VI-DAS DISPOSIÇÕES GERAIS</u></b>
    <br>
    Cláusula décima - A Sociedade, seus sócios e os investidores, devem também observar e cumprir todas as obrigações previstas neste Contrato. As partes, garantem que todas as informações e declarações prestadas neste Contrato e em outros documentos anexos, são completas, precisas, corretas, exatas e verdadeiras.
    <br>
    <br>
    § 1° - O Anexo mencionado neste contrato, é parte integrante ao presente documento, para todos os efeitos de direito. Na hipótese de divergências entre as disposições contidas no Anexo e no presente contrato, as disposições do Contrato deverão prevalecer.
    <br><br>
    § 2° - Cada Parte compromete-se e obriga-se a indenizar a outra Parte de todos e quaisquer ônus, custos, despesas, condenações, contingências, multas e penalidades de qualquer natureza que por acaso sejam incorridas pela outra Parte em decorrência de omissão, falsidade, ou infração da Lei, bem como as infrações de qualquer declaração e garantia prestada neste contrato.
    <br><br>
    Cláusula décima primeira - A responsabilidade pela apuração e pagamento dos impostos, taxas e/ou outros tributos, será da Parte cuja a legislação, vigente e aplicável, lhe atribua responsabilidade tributária.
    <br><br>
    Cláusula décima segunda - O presente contrato é o reflexo fiel dos entendimentos e acordos assumidos entre as Partes em relação ao objeto deste Contrato. Fica revogado, portanto, qualquer entendimento, seja ele verbal ou escrito, acordado anteriormente à assinatura deste contrato, referente ao mesmo objeto aqui discriminado.
    <br><br>
    Cláusula décima terceira - Sob pena de rescisão unilateral imediata deste contrato, sem prejuízo da cobrança de possíveis perdas e/ou danos a que der causa, cada uma das Partes é responsável e compromete-se a manter em sigilo todas as informações oriundas do objeto deste Contrato, bem como a própria existência deste documento.
    <br><br>
    Cláusula décima quarta - A alteração do presente Instrumento, somente poderá ser validada, mediante a prévia manifestação, expressa em instrumento escrito devidamente assinado pelas Partes e devidamente registrado no Foro da comarca eleita pelas partes.
    <br><br>
    § único
    <br><br>
    Sobrevindo caso fortuito ou de força maior os índices de rendimentos dispostos no item II, alínea “b” sofrerão modificações de acordo com as variáveis do mercado financeiros o que será aplicado pela contratada no presente contrato, com a notificação previa do contratante.
    <br><br>
    Cláusula décima quinta - As Partes poderão alterar o endereço fixado na cláusula de identificação, todavia, a alteração deverá ser acompanhada de prévia notificação escrita às demais Partes. Todas as notificações, consentimentos, solicitações e outras comunicações oficiais, para fins das disposições deste contrato, serão realizadas por escrito, e deverão ser entregues pessoalmente (quando possível), com o recolhimento da assinatura do comprovante de recebimento, nos endereços e para as pessoas indicadas na cláusula de identificação das Partes.
    <br>
    § 1° - Em caso de envio de notificações, consentimentos, solicitações e outras comunicações oficiais, por e-mail ou outros canais de comunicação, deverá obedecer ao acordo por escrito especificado por uma Parte à outra.
    <br>
    Cláusula décima sexta - O presente Instrumento vincula as Partes e seus sucessores a qualquer título, em caráter irrevogável e irretratável, ao fiel cumprimento deste Instrumento.
    <br>
    Cláusula décima nona - Sem prejuízo de outros recursos detidos pelas Partes, todas as disposições e obrigações assumidas neste Contrato são passíveis de execução específica, nos termos do Código de Processo Civil, sem prejuízo de eventuais perdas e danos para satisfação adequada do direito das Partes.
    <br><br><br>
    <b><u>VII-DO FORO</u></b>
    <br>
    Cláusula vigésima - As partes elegem o foro da Comarca do Município de Aracaju/Sergipe onde se localiza a sede da Sociedade, para dirimir quaisquer demandas oriundas do presente contrato.
    <br> <br>
    E, por estarem justos e contratados, firmam o presente instrumento, em 3 (três) vias de igual teor, juntamente com 2 (duas) testemunhas instrumentárias (que a tudo presenciaram e entenderam).
    <br><br><br>
    Investidor:
    _____________________________________________________________________

    <br><br><br>

    JIN INVEST MONEY EIRELI:
    _____________________________________________________________________

    <br><br><br>
    Testemunhas:

    <br><br><br>
    Nome: (...................................................................................................................................)
    <br><br><br>
    R.G.: (................................................................)
    <br><br><br>
    Nome: (...................................................................................................................................)
    <br><br><br>
    R.G.: (................................................................)

</div>
</body>
</html>
