import { Component } from '@angular/core';
import { CadastroPessoaModel } from '../../models/cadastro-pessoa.model';
import { FormBuilder, FormGroup, Validators, FormArray } from '@angular/forms';
import { PessoaService } from '../../services/pessoa.service';

@Component({
  selector: 'app-cadastro-pessoa',
  templateUrl: './cadastro-pessoa.component.html',
  styleUrl: './cadastro-pessoa.component.css'
})
export class CadastroPessoaComponent {
  pessoa = new CadastroPessoaModel()
  form!: FormGroup
  siglasEstadosBrasileiros = ['AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO']
  columns: string[] = ['nome', 'cpf', 'rg', 'cep', 'telefone' ,'actions']
  listaPessoas: any

  constructor(
    private formBuilder: FormBuilder,
    private pessoaService: PessoaService,
  ) {}

  async ngOnInit() {
    this.popularTabelaTelefones()

    const data: any = await this.pessoaService.findAll()
    const sanitizedData: any = this.sanitizeData(data)
    this.listaPessoas = sanitizedData
  }

  popularTabelaTelefones(num?: number) {
    if(num) {
      num = 5 - num
      for (let i = 1; i <= num; i++) {
        this.addTelefone();
      }
    } else{
      for (let i = 0; i < 5; i++) {
        this.addTelefone();
      }
    }
  }

  async sendForm() {
    this.pessoa.telefones = this.pessoa.telefones.filter(telefone => telefone.numero !== '' || telefone.descricao !== '');
    if(this.pessoa.id) {
      await this.pessoaService.editarPessoa(this.pessoa)
      this.listaPessoas = this.listaPessoas.map((p: any) => {
        return p.id === this.pessoa.id ? { ...this.pessoa } : p;
      });
    } else {
      await this.pessoaService.cadastarPessoa(this.pessoa)
      this.listaPessoas = [...this.listaPessoas, { ...this.pessoa }];
    }

    this.pessoa = new CadastroPessoaModel();
    this.popularTabelaTelefones()
  }

  editar(element: any) {
    this.pessoa = {
      id: element.id,
      nome: element.nome,
      cpf: element.cpf,
      rg: element.rg,
      cep: element.cep,
      logradouro: element.logradouro,
      complemento: element.complemento,
      setor: element.setor,
      cidade: element.cidade,
      uf: element.uf,
      telefones: element.telefones.map((telefone: any) => ({ ...telefone }))
    };

    this.popularTabelaTelefones(element.telefones.length)
  }

  async excluir() {
    await this.pessoaService.excluirPessoa(this.pessoa.id)
    this.listaPessoas = this.listaPessoas.filter((p: any) => p.id !== this.pessoa.id);
    this.pessoa = new CadastroPessoaModel();

    this.popularTabelaTelefones()
  }

  addTelefone(): void {
    this.pessoa.telefones.push({ numero: '', descricao: '' });
  }

  sanitizeData(data: any[]): any[] {
    return data.map((item: any) => {
        const cleanedItem: any = {};
        Object.keys(item).forEach((key: string) => {
            const newKey = key.replace(/"/g, '');
            cleanedItem[newKey] = item[key];
        });

        if (cleanedItem['telefones']) {
            cleanedItem['telefones'] = JSON.parse(cleanedItem['telefones']).map((telefone: any) => {
                return {
                    numero: telefone.numero.replace(/\\/g, ''),
                    descricao: telefone.descricao
                };
            });
        }

        return cleanedItem;
    });
  }
}
