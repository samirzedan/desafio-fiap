import { CommonModule } from '@angular/common';
import { Component, EventEmitter, inject, Input, OnInit, Output } from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  ValidationErrors,
  ValidatorFn,
  Validators,
} from '@angular/forms';
import { Aluno } from '../../../services/aluno';

export function cpfValidator(): ValidatorFn {
  return (control: AbstractControl): ValidationErrors | null => {
    const cpf = control.value?.replace(/\D/g, '');
    if (!cpf || cpf.length !== 11) return { cpfInvalido: true };

    if (/^(\d)\1{10}$/.test(cpf)) return { cpfInvalido: true };

    const calcDigito = (cpfArray: number[], peso: number) => {
      const sum = cpfArray.reduce((acc, val, i) => acc + val * (peso - i), 0);
      const resto = sum % 11;
      return resto < 2 ? 0 : 11 - resto;
    };

    const nums = cpf.split('').map((n: string) => +n);
    const digito1 = calcDigito(nums.slice(0, 9), 10);
    const digito2 = calcDigito(nums.slice(0, 10), 11);

    if (digito1 !== nums[9] || digito2 !== nums[10]) return { cpfInvalido: true };

    return null;
  };
}

export function strongPasswordValidator(): ValidatorFn {
  return (control: AbstractControl): ValidationErrors | null => {
    const value: string = control.value ?? '';

    if (!value) return { required: true };

    const hasUpperCase = /[A-Z]/.test(value);
    const hasLowerCase = /[a-z]/.test(value);
    const hasNumber = /\d/.test(value);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);
    const isValidLength = value.length >= 8;

    const valid = hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar && isValidLength;

    return valid ? null : { senhaFraca: true };
  };
}

@Component({
  selector: 'app-aluno-dialog',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './aluno-dialog.html',
  styleUrl: './aluno-dialog.css',
})
export class AlunoDialog implements OnInit {
  private _alunoService = inject(Aluno);

  @Input() aluno: any = null;
  @Input() opened = false;
  @Output() openedChange = new EventEmitter<boolean>();
  @Output() saved = new EventEmitter<boolean>();

  protected form: FormGroup = new FormGroup({
    nome: new FormControl('', [Validators.required, Validators.minLength(3)]),
    data_nascimento: new FormControl('', [Validators.required]),
    cpf: new FormControl('', [Validators.required, cpfValidator()]),
    email: new FormControl('', [Validators.required, Validators.email]),
    senha: new FormControl('', [Validators.required, strongPasswordValidator()]),
  });

  public ngOnInit(): void {
    if (!!this.aluno) {
      this.form.patchValue(this.aluno);
      this.form.get('senha')?.disable();
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

    if (this.aluno?.id) {
      this._alunoService.update(this.aluno.id, this.form.value).subscribe(() => {
        this.form.reset();
        this.close(true);
      });
      return;
    }
    this._alunoService.create(this.form.value).subscribe(() => {
      this.form.reset();
      this.close(true);
    });
  }

  private close(saved: boolean = false) {
    this.opened = false;
    this.openedChange.emit(this.opened);
    if (saved) {
      this.saved.emit(true);
    }
  }
}
