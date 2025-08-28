import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import { BehaviorSubject, combineLatest, startWith, switchMap, tap } from 'rxjs';
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
  protected totalPages: number = 0;
  protected queryCtrl = new FormControl<string>('');
  protected currentPage$ = new BehaviorSubject<number>(1);
  protected alunoSelected: any;

  protected alunos$ = combineLatest([
    this.queryCtrl.valueChanges.pipe(startWith(this.queryCtrl.value)),
    this.currentPage$,
  ]).pipe(
    switchMap(([query, page]) => this._alunoService.list(query, page)),
    tap((res) => {
      this.totalPages = res.data.pages;
    })
  );

  protected onCreateAluno(): void {
    this.alunoSelected = null;
    this.alunoDialogOpened = true;
  }

  protected onEditAluno(aluno: any): void {
    this.alunoSelected = aluno;
    this.alunoDialogOpened = true;
  }

  protected onDeleteAluno(alunoId: number): void {
    this._alunoService.delete(alunoId).subscribe();
    this.onPageNavigate(1);
  }

  protected onPageNavigate(page: number): void {
    this.currentPage$.next(page);
  }

  protected onDialogClosed(event: any) {
    if (event) {
      this.onPageNavigate(1);
    }
  }

  protected get pagesArray(): number[] {
    return Array.from({ length: this.totalPages }, (_, i) => i + 1);
  }
}
