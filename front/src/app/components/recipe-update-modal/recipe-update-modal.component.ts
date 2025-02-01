import { CommonModule } from '@angular/common';
import { Component, Input, Output, EventEmitter } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-recipe-update-modal',
  templateUrl: './recipe-update-modal.component.html',
  styleUrls: ['./recipe-update-modal.component.scss'],
  imports: [CommonModule, ReactiveFormsModule, FormsModule]
})
export class RecipeUpdateModalComponent {
  // Recevoir la recette sélectionnée
  @Input() selectedRecipe: any;
  // Gérer la visibilité de la modale
  @Input() isVisible: boolean = false;
  
  @Output() close = new EventEmitter<void>();

  // Méthode pour fermer la modale
  closeModal() {
    this.close.emit();
  }

  // Méthode pour mettre à jour la recette
  updateRecipe() {
    // Logique de mise à jour (enverra les données modifiées au parent via un service)
    console.log("Mise à jour de la recette", this.selectedRecipe);
    this.closeModal(); // Fermer la modale après mise à jour
  }
}
