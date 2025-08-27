import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { BehaviorSubject, Observable, of } from 'rxjs';
import { SystemConstants } from '../config/system.constants';

@Injectable({
  providedIn: 'root',
})
export class Auth {
  private _http = inject(HttpClient);
  private _url = `${SystemConstants.api}`;
  private _tokenKey: string = 'auth_token';

  private _isLoggedIn = new BehaviorSubject<boolean>(this.hasToken());
  public isLoggedIn$ = this._isLoggedIn.asObservable();

  public login(body: any): Observable<any> {
    return this._http.post(`${this._url}/users/login`, body);
  }

  public logout(): Observable<any> {
    this.clearToken();
    return of(true);
  }

  public signUp(body: any): Observable<any> {
    return this._http.post(`${this._url}/users`, body);
  }

  public setToken(token: string): void {
    if (!token) {
      return;
    }
    this._isLoggedIn.next(true);
    sessionStorage.setItem(this._tokenKey, token);
  }

  public getToken(): string | null {
    return sessionStorage.getItem(this._tokenKey);
  }

  public hasToken(): boolean {
    return (
      !!sessionStorage.getItem(this._tokenKey) && sessionStorage.getItem(this._tokenKey) !== 'null'
    );
  }

  public clearToken(): void {
    this._isLoggedIn.next(false);
    sessionStorage.removeItem(this._tokenKey);
  }
}
