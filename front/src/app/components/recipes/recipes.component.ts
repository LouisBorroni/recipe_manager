import { Component, OnInit } from '@angular/core';
import { Observable } from 'rxjs';
import { Store } from '@ngrx/store';
import { selectRecipes } from '../../stores/user/user.selector';
import { RecipeModaleComponent } from '../../shared/recipe-modale/recipe-modale.component';
import { CommonModule } from '@angular/common';
import { RecipeService } from '../../servcices/recipe.service';
import { RecipeUpdateModalComponent } from '../recipe-update-modal/recipe-update-modal.component';

@Component({
  selector: 'app-recipes',
  imports: [CommonModule, RecipeModaleComponent, RecipeUpdateModalComponent],
  templateUrl: './recipes.component.html',
  styleUrl: './recipes.component.scss'
})
export class RecipesComponent implements OnInit {
  categories = [
    { name: 'Desserts', icon: 'fa-cake' },
    { name: 'Plats principaux', icon: 'fa-utensils' },
    { name: 'Entrées', icon: 'fa-lemon' }
  ];

  recipes$: Observable<any[]>;
  recipes: any[] = []; 
  currentPage = 0;
  itemsPerPage = 8;
  selectedRecipe: any = null;
  isModalVisible = false;
  selectedRecipeToDelete: any = null;
  isDeleteModalVisible = false
  isUpdateModalVisible: boolean = false;


  constructor(private store: Store, private recipeService: RecipeService) {
    this.recipes$ = this.store.select(selectRecipes);
  }

  ngOnInit(): void {
    this.recipes$.subscribe((recipes) => {
      this.recipes = recipes; 
    });
  }

  openUpdateModal(recipe: any, event: Event) {
    event.stopPropagation();  // Empêche d'ouvrir la carte de recette
    this.selectedRecipe = recipe;
    this.isUpdateModalVisible = true;
  }

  closeUpdateModal() {
    this.isUpdateModalVisible = false;
  }
  

  confirmDelete(recipe: any, event: Event) {
    event.stopPropagation(); 
    this.selectedRecipeToDelete = recipe;
    this.isDeleteModalVisible = true;
  }

  deleteRecipe() {
    if (!this.selectedRecipeToDelete) return;
  
    this.recipeService.deleteRecipe(this.selectedRecipeToDelete.id).subscribe({
      next: () => {
        this.recipes = this.recipes.filter(r => r.id !== this.selectedRecipeToDelete.id);
        this.isDeleteModalVisible = false;
        this.selectedRecipeToDelete = null;
      },
      error: (error) => console.error('Error deleting recipe:', error),
    });
  }

  closeDeleteModal() {
    this.isDeleteModalVisible = false;
    this.selectedRecipeToDelete = null;
  }


  openModal(recipe: any) {
    this.selectedRecipe = recipe;
    this.isModalVisible = true;
    this.recipeService.addRecipeView(recipe.id).subscribe({
      // TODO incrémenter le nombre de vues à la volée? 
      // next: (data) => {
        
      // },
      error: (error) => console.error('Error updating views:', error)
    });
  }

  closeModal() {
    this.isModalVisible = false;
    this.selectedRecipe = null;
  }

  get paginatedRecipes() {
    const start = this.currentPage * this.itemsPerPage;
    return this.recipes.slice(start, start + this.itemsPerPage);
  }

  getTotalPages(): number {
    return Math.ceil(this.recipes.length / this.itemsPerPage);
  }

  nextPage() {
    if (this.currentPage + 1 < this.getTotalPages()) {
      this.currentPage++;
    }
  }

  prevPage() {
    if (this.currentPage > 0) {
      this.currentPage--;
    }
  }

  toggleLike(recipe: any) {
    recipe.liked = !recipe.liked;
  }

  getCategoryIcon(category: string): string {
    switch (category) {
      case 'Dessert':
        return 'fa-cake';
      case 'Plat principal':
        return 'fa-utensils';
      case 'Entrée':
        return 'fa-lemon';
      default:
        return 'fa-question-circle'; 
    }
  }
}
