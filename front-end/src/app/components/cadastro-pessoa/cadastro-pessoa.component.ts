import { Component } from '@angular/core';
import { CadastroPessoaModel } from '../../models/cadastro-pessoa.model';
import { FormBuilder, FormGroup, Validators, FormArray } from '@angular/forms';

@Component({
  selector: 'app-cadastro-pessoa',
  templateUrl: './cadastro-pessoa.component.html',
  styleUrl: './cadastro-pessoa.component.css'
})
export class CadastroPessoaComponent {
pessoa = new CadastroPessoaModel()
form!: FormGroup
siglasEstadosBrasileiros = ['AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO']
mockPessoas = [
  {nome: "Ale", cpf: '0549414321', rg: '5578345', cep: "74603060", telefones: [{numero: '62996766078', descricao: 'teste'}, {numero: '62996768878', descricao: 'teste2'}]},
  {nome: "Jao", cpf: '0549415321', rg: '5574345', cep: "74623060", telefones: [{numero:'62996556078', descricao: 'teste'}]},
]
listaPessoas = this.mockPessoas
columns: string[] = ['nome', 'cpf', 'rg', 'cep', 'telefone' ,'actions']

telefonesCadastro: {numero: string, descricao: string}[] = [];

constructor(
  private formBuilder: FormBuilder,
) {}

  async ngOnInit() {
    this.form = this.formBuilder.group({
      telefones: this.formBuilder.array([])
    });
  }

  async sendForm() {
    const {nome, cpf} = this.form.value
    console.log(nome, cpf)
  }

  editar(element: any) {
    console.log(element)
  }

  get telefonesFormArray(): FormArray {
    return this.form.get('telefones') as FormArray;
  }

  addTelefone(): void {
    this.telefonesFormArray.push(this.formBuilder.group({
      numero: ['', Validators.required],
      descricao: ['', Validators.required]
    }));
  }

  console(a:any){
    console.log(a)
  }
}
