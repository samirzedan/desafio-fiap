import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { SystemConstants } from '../config/system.constants';

@Injectable({
  providedIn: 'root',
})
export class Aluno {
  private _http = inject(HttpClient);
  private _url = `${SystemConstants.api}`;

  public list(query?: string | null, page?: number | null): Observable<any> {
    const params = new URLSearchParams();
    if (query) params.set('query', query);
    if (page != null) params.set('page', page.toString());
    return this._http.get(`${this._url}/students?${params.toString()}`);
  }

  public listAll(): Observable<any> {
    return this._http.get(`${this._url}/students-all`);
  }

  public show(alunoId: number): Observable<any> {
    return this._http.get(`${this._url}/students/${alunoId}`);
  }

  public create(body: any): Observable<any> {
    return this._http.post(`${this._url}/students`, body);
  }

  public update(alunoId: number, body: any): Observable<any> {
    return this._http.put(`${this._url}/students/${alunoId}`, body);
  }

  public delete(alunoId: number): Observable<any> {
    return this._http.delete(`${this._url}/students/${alunoId}`);
  }

  public assignClass(alunoId: number, turmaId?: number | null): Observable<any> {
    const classId = turmaId !== null && turmaId !== undefined ? Number(turmaId) : null;
    return this._http.patch(`${this._url}/students/${alunoId}/assign-class`, { class_id: classId });
  }
}
