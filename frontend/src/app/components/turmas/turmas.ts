import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { FormControl, ReactiveFormsModule } from '@angular/forms';
import { BehaviorSubject, combineLatest, startWith, switchMap, tap } from 'rxjs';
import { Turma } from '../../services/turma';
import { TurmaAlunosDialog } from './turma-alunos-dialog/turma-alunos-dialog';
import { TurmaDialog } from './turma-dialog/turma-dialog';

@Component({
  selector: 'app-turmas',
  imports: [CommonModule, ReactiveFormsModule, TurmaDialog, TurmaAlunosDialog],
  templateUrl: './turmas.html',
  styleUrl: './turmas.css',
})
export class Turmas {
  private _turmaService = inject(Turma);

  protected turmaDialogOpened = false;
  protected turmaAlunosDialogOpened = false;
  protected totalPages: number = 0;
  protected queryCtrl = new FormControl<string>('');
  protected currentPage$ = new BehaviorSubject<number>(1);
  protected turmaSelected: any;
  protected turmaSelectedToView: any;

  protected turmas$ = combineLatest([
    this.queryCtrl.valueChanges.pipe(startWith(this.queryCtrl.value)),
    this.currentPage$,
  ]).pipe(
    switchMap(([query, page]) => this._turmaService.list(query, page)),
    tap((res) => {
      this.totalPages = res.data.pages;
    })
  );

  protected onViewAlunos(turmaId: number): void {
    this._turmaService.show(turmaId).subscribe((res) => {
      this.turmaSelectedToView = res.data;
      this.turmaAlunosDialogOpened = true;
    });
  }

  protected onCreateTurma(): void {
    this.turmaSelected = null;
    this.turmaDialogOpened = true;
  }

  protected onEditTurma(turma: any): void {
    this.turmaSelected = turma;
    this.turmaDialogOpened = true;
  }

  protected onDeleteTurma(turma: any): void {
    if (turma.total_alunos) {
      alert('Só é possível excluir turmas que não tenham alunos matriculados!');
      return;
    }
    this._turmaService.delete(turma.id).subscribe({
      next: () => {
        this.onPageNavigate(1);
      },
      error: () => {
        alert('Erro ao excluir turma!');
      },
    });
  }

  protected onPageNavigate(page: number): void {
    this.currentPage$.next(page);
  }

  protected onDialogClosed(event: any): void {
    if (event) {
      this.onPageNavigate(1);
    }
  }

  protected get pagesArray(): number[] {
    return Array.from({ length: this.totalPages }, (_, i) => i + 1);
  }
}
