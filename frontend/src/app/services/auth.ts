import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { SystemConstants } from '../config/system.constants';

@Injectable({
  providedIn: 'root',
})
export class Auth {
  private _http = inject(HttpClient);
  private _url = `${SystemConstants.api}`;

  public login(body: any): Observable<any> {
    return this._http.post(`${this._url}/users/login`, body);
  }
}
