import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-turma-alunos-dialog',
  imports: [CommonModule],
  templateUrl: './turma-alunos-dialog.html',
  styleUrl: './turma-alunos-dialog.css',
})
export class TurmaAlunosDialog {
  @Input() turma: any = null;
  @Input() opened = false;
  @Output() openedChange = new EventEmitter<boolean>();

  protected onClose() {
    this.close();
  }

  private close(saved: boolean = false) {
    this.opened = false;
    this.openedChange.emit(this.opened);
  }
}
