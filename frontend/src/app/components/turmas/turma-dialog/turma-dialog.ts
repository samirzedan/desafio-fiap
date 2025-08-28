import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-turma-dialog',
  imports: [],
  templateUrl: './turma-dialog.html',
  styleUrl: './turma-dialog.css',
})
export class TurmaDialog {
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
