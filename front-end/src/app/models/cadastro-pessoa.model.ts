export class CadastroPessoaModel {
  id?: string = '';
  nome: string = '';
  cpf: string = '';
  rg: string = '';
  cep: string = '';
  logradouro: string = '';
  complemento: string = '';
  setor: string = '';
  cidade: string = '';
  uf: string = '';
  telefones: Telefones[] = [];
}

interface Telefones {
  numero: string;
  descricao: string;
}
