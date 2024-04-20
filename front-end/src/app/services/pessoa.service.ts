import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { lastValueFrom } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PessoaService {
  constructor(private httpClient: HttpClient) {}
  url = 'http://localhost/index.php';

  async findAll() {
    return await lastValueFrom(this.httpClient.get(`${this.url}/lista-todas-pessoas`))
  }

  async cadastarPessoa(body: any) {
    return await lastValueFrom(this.httpClient.post(`${this.url}/pessoa`, body))
  }

  async editarPessoa(body: any) {
    return await lastValueFrom(this.httpClient.put(`${this.url}/pessoa?&pessoa-id=${body.id}`, body))
  }

  async excluirPessoa(id: any) {
    return await lastValueFrom(this.httpClient.delete(`${this.url}/pessoa?&pessoa-id=${id}`))
  }
}
