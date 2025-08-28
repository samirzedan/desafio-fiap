import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { SystemConstants } from '../config/system.constants';

@Injectable({
  providedIn: 'root',
})
export class Turma {
  private _http = inject(HttpClient);
  private _url = `${SystemConstants.api}`;

  public list(query?: string | null, page?: number | null): Observable<any> {
    const params = new URLSearchParams();
    if (query) params.set('query', query);
    if (page != null) params.set('page', page.toString());
    return this._http.get(`${this._url}/classes?${params.toString()}`);
  }

  public listAll(): Observable<any> {
    return this._http.get(`${this._url}/classes-all`);
  }

  public show(turmaId: number): Observable<any> {
    return this._http.get(`${this._url}/classes/${turmaId}`);
  }

  public create(body: any): Observable<any> {
    return this._http.post(`${this._url}/classes`, body);
  }

  public update(turmaId: number, body: any): Observable<any> {
    return this._http.put(`${this._url}/classes/${turmaId}`, body);
  }

  public delete(turmaId: number): Observable<any> {
    return this._http.delete(`${this._url}/classes/${turmaId}`);
  }
}
