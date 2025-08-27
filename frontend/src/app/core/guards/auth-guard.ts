import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { map, take } from 'rxjs';
import { Auth } from '../../services/auth';

export const authGuard: CanActivateFn = (route, state) => {
  const _authService = inject(Auth);
  const _router = inject(Router);

  return _authService.isLoggedIn$.pipe(
    take(1),
    map((isLoggedIn) => {
      if (!isLoggedIn) {
        _router.navigate(['/login']);
        return false;
      }
      return true;
    })
  );
};
