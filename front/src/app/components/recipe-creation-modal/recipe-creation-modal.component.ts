import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RecipeService } from '../../servcices/recipe.service';

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

  constructor(private fb: FormBuilder, private recipeService: RecipeService) {
    this.recipeForm = this.fb.group({
      name: ['', Validators.required],
      category: ['', Validators.required],
      image: [null, Validators.required],
      cookingSteps: ['', Validators.required] 
    });
  }

  get cookingSteps() {
    return this.recipeForm.get('cookingSteps');
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
    if (this.recipeForm.valid) {
      const cookingStepsArray = this.recipeForm.value.cookingSteps
        .split(',')
        .map((step: string) => step.trim()) 
        .filter((step: string) => step.length > 0); 
  
      const recipeData = {
        name: this.recipeForm.value.name,
        category: this.recipeForm.value.category,
        image: this.recipeForm.value.image,
        cookingSteps: cookingStepsArray
      };
  
      this.recipeService.createRecipe(recipeData).subscribe(
        (data) => {
          console.log('Recette créée avec succès:');
          this.closeModal.emit(); 
        },
        (error) => {
          console.error('Erreur lors de la création de la recette:', error);
        }
      );
    } else {
      console.log('Formulaire invalide');
    }
  }
  
}
