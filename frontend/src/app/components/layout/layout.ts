import { Component, inject } from '@angular/core';
import { Router, RouterLink, RouterOutlet } from '@angular/router';
import { Auth } from '../../services/auth';

@Component({
  selector: 'app-layout',
  imports: [RouterOutlet, RouterLink],
  templateUrl: './layout.html',
  styleUrl: './layout.css',
})
export class Layout {
  private _authService = inject(Auth);
  private _router = inject(Router);

  protected onLogout(): void {
    this._authService.logout().subscribe(() => {
      this._router.navigate(['/login']);
    });
  }
}
