import { Routes } from '@angular/router';
import { Alunos } from './components/alunos/alunos';
import { Cadastro } from './components/cadastro/cadastro';
import { Layout } from './components/layout/layout';
import { Login } from './components/login/login';
import { Turmas } from './components/turmas/turmas';

export const routes: Routes = [
  {
    path: '',
    redirectTo: 'login',
    pathMatch: 'full',
  },
  {
    path: 'login',
    component: Login,
  },
  {
    path: 'cadastro',
    component: Cadastro,
  },
  {
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
