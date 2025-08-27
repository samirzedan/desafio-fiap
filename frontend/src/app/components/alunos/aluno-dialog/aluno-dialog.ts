import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-aluno-dialog',
  imports: [],
  templateUrl: './aluno-dialog.html',
  styleUrl: './aluno-dialog.css',
})
export class AlunoDialog {
  @Input() opened = false;
  @Output() openedChange = new EventEmitter<boolean>();

  protected onClose() {
    this.close();
  }

  protected onSave() {
    //
  }

  private close() {
    this.opened = false;
    this.openedChange.emit(this.opened);
  }
}
