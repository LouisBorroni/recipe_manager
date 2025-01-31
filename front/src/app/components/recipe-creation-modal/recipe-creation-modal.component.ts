import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, FormArray, Validators, AbstractControl, ValidationErrors, FormsModule, ReactiveFormsModule } from '@angular/forms';

// Validator personnalisé pour le FormArray
export function cookingStepsValidator(control: AbstractControl): ValidationErrors | null {
  const formArray = control as FormArray;
  if (formArray.length > 0) {
    return null; // valid si le FormArray a des éléments
  }
  return { 'cookingStepsRequired': true }; // invalid si le FormArray est vide
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
      cookingSteps: this.fb.array([], cookingStepsValidator) // Application du validateur ici
    });
  }

  get cookingSteps(): FormArray {
    return this.recipeForm.get('cookingSteps') as FormArray;
  }

  addStep() {
    const stepGroup = this.fb.group({
      step: ['', Validators.required]  // Chaque étape est une chaîne vide au départ et requiert une saisie
    });

    this.cookingSteps.push(stepGroup);  // Ajoute le groupe au FormArray
  }

  removeStep(index: number) {
    this.cookingSteps.removeAt(index);
  }

  onImageChange(event: any) {
    const file = event.target.files[0];  // Récupérer le fichier sélectionné
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        this.imagePreview = reader.result; // Image en base64 ou Blob
        this.recipeForm.get('image')?.setValue(file); // Stocker l'image dans le formulaire
      };
      reader.readAsDataURL(file); // Convertir l'image en base64 pour affichage
    }
  }

  submitRecipe() {
    if (this.recipeForm.valid && this.cookingSteps.length > 0) {
      this.closeModal.emit(); 
    } else {
      console.log('Formulaire invalide');
    }
  }
}
