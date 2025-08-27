import { Routes } from '@angular/router';
import { Alunos } from './components/alunos/alunos';
import { Cadastro } from './components/cadastro/cadastro';
import { Layout } from './components/layout/layout';
import { Login } from './components/login/login';
import { Turmas } from './components/turmas/turmas';
import { authGuard } from './core/guards/auth-guard';
import { guestGuard } from './core/guards/guest-guard';

export const routes: Routes = [
  {
    path: '',
    redirectTo: 'login',
    pathMatch: 'full',
  },
  {
    canActivate: [guestGuard],
    path: 'login',
    component: Login,
  },
  {
    canActivate: [guestGuard],
    path: 'cadastro',
    component: Cadastro,
  },
  {
    canActivate: [authGuard],
    path: '',
    component: Layout,
    children: [
      {
        path: 'alunos',
        component: Alunos,
      },
      {
        path: 'turmas',
        component: Turmas,
      },
    ],
  },
];
