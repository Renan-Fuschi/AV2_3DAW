function selecionarPagamento(metodo) {
    let mensagem;
  
    switch (metodo) {
      case 'cartao':
        mensagem = 'Você escolheu pagamento em Cartão!';
        break;
      case 'pix':
        mensagem = 'Você escolheu pagamento via PIX!';
        break;
      case 'boleto':
        mensagem = 'Você escolheu pagamento por Boleto!';
        break;
      default:
        mensagem = 'Método de pagamento inválido.';
    }
  
    alert(mensagem);
  }
  