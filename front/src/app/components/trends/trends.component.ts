import { Component } from '@angular/core';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs';
import { RecipeService } from '../../servcices/recipe.service';
import { CommonModule } from '@angular/common';
import { RecipeModaleComponent } from '../../shared/recipe-modale/recipe-modale.component';

@Component({
  selector: 'app-trends',
  imports: [CommonModule, RecipeModaleComponent],
  templateUrl: './trends.component.html',
  styleUrl: './trends.component.scss'
})
export class TrendsComponent {
  categories = [
    { name: 'Desserts', icon: 'fa-cake' },
    { name: 'Plats principaux', icon: 'fa-utensils' },
    { name: 'Entrées', icon: 'fa-lemon' }
  ];

  recipes$: Observable<any[]>;
  recipes: any[] = []; 

  constructor( private recipeService: RecipeService) {
    this.recipes$ = this.recipeService.getTrendRecipes();
  }

  ngOnInit(): void {
    this.recipes$.subscribe((recipes) => {
      this.recipes = recipes; 
    });
  }

  currentPage = 0;
  itemsPerPage = 8;
  selectedRecipe: any = null;
  isModalVisible = false;

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
