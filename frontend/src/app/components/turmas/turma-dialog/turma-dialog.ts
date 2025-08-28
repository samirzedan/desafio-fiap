import { CommonModule } from '@angular/common';
import { Component, EventEmitter, inject, Input, Output } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Turma } from '../../../services/turma';

@Component({
  selector: 'app-turma-dialog',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './turma-dialog.html',
  styleUrl: './turma-dialog.css',
})
export class TurmaDialog {
  private _turmaService = inject(Turma);

  @Input() turma: any = null;
  @Input() opened = false;
  @Output() openedChange = new EventEmitter<boolean>();
  @Output() saved = new EventEmitter<boolean>();

  protected form: FormGroup = new FormGroup({
    nome: new FormControl('', [Validators.required, Validators.minLength(3)]),
    descricao: new FormControl('', [Validators.required]),
  });

  public ngOnInit(): void {
    if (!!this.turma) {
      this.form.patchValue(this.turma);
    }
  }

  protected get f() {
    return this.form.controls;
  }

  protected onClose() {
    this.close();
  }

  protected onSave() {
    if (this.form.invalid) {
      this.form.markAllAsTouched();
      return;
    }

    if (this.turma?.id) {
      this._turmaService.update(this.turma.id, this.form.value).subscribe(() => {
        this.form.reset();
        this.close(true);
      });
      return;
    }
    this._turmaService.create(this.form.value).subscribe(() => {
      this.form.reset();
      this.close(true);
    });
  }

  private close(saved: boolean = false) {
    this.form.reset();
    this.opened = false;
    this.openedChange.emit(this.opened);
    if (saved) {
      this.saved.emit(true);
    }
  }
}
