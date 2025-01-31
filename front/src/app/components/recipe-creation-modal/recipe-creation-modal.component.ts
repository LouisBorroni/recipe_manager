import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, FormArray, Validators, AbstractControl, ValidationErrors, FormsModule, ReactiveFormsModule } from '@angular/forms';

export function cookingStepsValidator(control: AbstractControl): ValidationErrors | null {
  const formArray = control as FormArray;
  if (formArray.length > 0) {
    return null;
  }
  return { 'cookingStepsRequired': true };
}

@Component({
  selector: 'app-recipe-creation-modal',
  templateUrl: './recipe-creation-modal.component.html',
  styleUrls: ['./recipe-creation-modal.component.scss'],
  imports: [CommonModule, FormsModule, ReactiveFormsModule]
})
export class RecipeCreationModalComponent {
  @Output() closeModal = new EventEmitter<void>();

  recipeForm: FormGroup;
  imagePreview: string | ArrayBuffer | null = null;

  constructor(private fb: FormBuilder) {
    this.recipeForm = this.fb.group({
      name: ['', Validators.required],
      category: ['', Validators.required],
      image: [null, Validators.required],
      cookingSteps: this.fb.array([], cookingStepsValidator)
    });
  }

  get cookingSteps(): FormArray {
    return this.recipeForm.get('cookingSteps') as FormArray;
  }

  addStep() {
    const stepGroup = this.fb.group({
      step: ['', Validators.required]  
    });

    this.cookingSteps.push(stepGroup); 
  }

  removeStep(index: number) {
    this.cookingSteps.removeAt(index);
  }

  onImageChange(event: any) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        this.imagePreview = reader.result as string | ArrayBuffer;
        this.recipeForm.patchValue({ image: this.imagePreview });
      };
      reader.readAsDataURL(file);
    }
  }

  submitRecipe() {
    if (this.recipeForm.valid && this.cookingSteps.length > 0) {
      this.closeModal.emit();
      console.log(this.recipeForm)
    } else {
      console.log('Formulaire invalide');
    }
  }
}
