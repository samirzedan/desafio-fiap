import { CommonModule } from '@angular/common';
import { Component, EventEmitter, inject, Input, Output } from '@angular/core';
import { FormControl, ReactiveFormsModule, Validators } from '@angular/forms';
import { map } from 'rxjs';
import { Turma } from '../../../services/turma';

@Component({
  selector: 'app-aluno-turmas-dialog',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './aluno-turmas-dialog.html',
  styleUrl: './aluno-turmas-dialog.css',
})
export class AlunoTurmasDialog {
  private _turmaService = inject(Turma);

  @Input() aluno: any = null;
  @Input() opened = false;
  @Output() openedChange = new EventEmitter<boolean>();
  @Output() turmaSelected = new EventEmitter<{ turmaId: number; alunoId: number } | null>();

  protected turmas$ = this._turmaService.listAll().pipe(map((res) => res.data));
  protected turmaCtrl: FormControl = new FormControl(null, [Validators.required]);

  protected onClose() {
    this.close();
  }

  protected onSave() {
    if (this.turmaCtrl.invalid) {
      return;
    }

    this.close(this.turmaCtrl.value);
    this.turmaCtrl.reset();
  }

  private close(turmaId?: number) {
    this.opened = false;
    this.openedChange.emit(this.opened);
    if (turmaId) {
      this.turmaSelected.emit({ turmaId, alunoId: this.aluno.id });
    }
    this.turmaSelected.emit(null);
  }
}
