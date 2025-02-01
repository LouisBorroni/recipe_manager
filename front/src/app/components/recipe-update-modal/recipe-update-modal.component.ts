import { CommonModule } from '@angular/common';
import { Component, Input, Output, EventEmitter, OnChanges } from '@angular/core';
import { FormBuilder, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { RecipeService } from '../../servcices/recipe.service';

@Component({
  selector: 'app-recipe-update-modal',
  templateUrl: './recipe-update-modal.component.html',
  styleUrls: ['./recipe-update-modal.component.scss'],
  imports: [CommonModule, ReactiveFormsModule, FormsModule]
})
export class RecipeUpdateModalComponent implements OnChanges {
  @Input() selectedRecipe: any;
  @Input() isVisible: boolean = false;
  @Output() close = new EventEmitter<void>();

  recipeForm: FormGroup;
  imagePreview: string | ArrayBuffer | null = null;

  constructor(private fb: FormBuilder, private recipeService: RecipeService) {
    this.recipeForm = this.fb.group({
      name: ['', Validators.required],
      category: ['', Validators.required],
      image: [''],  
      cookingSteps: ['', Validators.required],
    });
  }

  ngOnChanges() {
    if (this.selectedRecipe) {
      this.recipeForm = this.fb.group({
        name: [this.selectedRecipe.name, Validators.required],
        category: [this.selectedRecipe.category, Validators.required],
        image: [this.selectedRecipe.image || ''], 
        cookingSteps: [this.selectedRecipe.cookingSteps?.join(', ') || '', Validators.required],
      });

      this.imagePreview = this.selectedRecipe.image || null;
    }
  }

  closeModal() {
    this.close.emit();
  }

  // Méthode pour prévisualiser l'image
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

  updateRecipe() {
    if (this.recipeForm.valid) {
      const updatedRecipe = {
        ...this.recipeForm.value,
        cookingSteps: this.recipeForm.value.cookingSteps
          .split(',')
          .map((step: string) => step.trim()) 
      };
      // Envoi des modifications via le service
      this.recipeService.updateRecipe(this.selectedRecipe.id, updatedRecipe).subscribe(
        (response) => {
          console.log('Recette mise à jour', response);
          this.closeModal(); 
        },
        (error) => {
          console.error('Erreur lors de la mise à jour de la recette', error);
        }
      );
    }
}

}
