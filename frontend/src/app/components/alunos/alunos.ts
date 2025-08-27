import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import { BehaviorSubject, combineLatest, startWith, switchMap } from 'rxjs';
import { Aluno } from '../../services/aluno';
import { AlunoDialog } from './aluno-dialog/aluno-dialog';

@Component({
  selector: 'app-alunos',
  imports: [CommonModule, ReactiveFormsModule, AlunoDialog],
  templateUrl: './alunos.html',
  styleUrl: './alunos.css',
})
export class Alunos {
  private _alunoService = inject(Aluno);

  protected alunoDialogOpened = false;
  protected queryCtrl = new FormControl<string>('');
  protected currentPage$ = new BehaviorSubject<number>(1);

  protected alunos$ = combineLatest([
    this.queryCtrl.valueChanges.pipe(startWith(this.queryCtrl.value)),
    this.currentPage$,
  ]).pipe(switchMap(([query, page]) => this._alunoService.list(query, page)));

  protected onCreateStudent(): void {
    this.alunoDialogOpened = true;
  }
}
