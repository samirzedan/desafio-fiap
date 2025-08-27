import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { map } from 'rxjs';
import { Auth } from '../../services/auth';

@Component({
  selector: 'app-login',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './login.html',
  styleUrl: './login.css',
})
export class Login {
  private _authService = inject(Auth);
  private _router = inject(Router);

  protected form: FormGroup = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    senha: new FormControl('', [Validators.required]),
  });

  protected onLogin(): void {
    if (this.form.invalid) {
      this.form.markAllAsTouched();
      return;
    }
    const body = this.form.value;
    this._authService
      .login(body)
      .pipe(map((res) => (res.success ? res.data : null)))
      .subscribe({
        next: (token) => {
          if (!token) {
            alert('Ocorreu um erro ao entrar!');
            return;
          }
          this._authService.setToken(token);
          this._router.navigate(['/turmas']);
        },
        error: (err) => {
          alert('Ocorreu um erro ao entrar!');
        },
      });
  }
}
