const handleCPF = (event) => {
    let input = event.target;
    input.value = cpfMask(input.value);
  };
  
  const cpfMask = (value) => {
    if (!value) return "";
    value = value.replace(/\D/g, ''); // Remove tudo que não for número
    value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca o primeiro ponto
    value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Coloca o segundo ponto
    value = value.replace(/(\d{3})(\d{2})$/, '$1-$2'); // Coloca o traço antes dos últimos 2 dígitos
    return value;
  };