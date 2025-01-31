import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RecipeModaleComponent } from '../../shared/recipe-modale/recipe-modale.component';

@Component({
  selector: 'app-recipes',
  imports: [CommonModule, RecipeModaleComponent],
  templateUrl: './recipes.component.html',
  styleUrl: './recipes.component.scss'
})
export class RecipesComponent {
  categories = [
    { name: 'Desserts', icon: 'fa-cake' },
    { name: 'Plats principaux', icon: 'fa-utensils' },
    { name: 'Entrées', icon: 'fa-lemon' }
  ];

  recipes = [
    {
      name: 'Tarte aux fraises', 
      image: 'assets/burger.jpg', 
      creator: 'Alice', 
      views: 250, 
      liked: false, 
      category: 'Dessert',
      cookingSteps: [
        'Préparez la pâte sablée.',
        'Faites cuire la pâte à blanc.',
        'Préparez la crème pâtissière.',
        'Garnissez la pâte cuite avec la crème.',
        'Disposez les fraises sur la crème.'
      ]
    },
    {
      name: 'Pâtes carbonara', 
      image: 'assets/burger.jpg', 
      creator: 'Bob', 
      views: 180, 
      liked: false, 
      category: 'Plat principal',
      cookingSteps: [
        'Faites bouillir de l\'eau salée.',
        'Cuire les pâtes al dente.',
        'Faites revenir des lardons dans une poêle.',
        'Ajoutez de la crème et du fromage râpé aux lardons.',
        'Mélangez les pâtes avec la sauce carbonara.'
      ]
    },
    {
      name: 'Pizza Margherita', 
      image: 'assets/burger.jpg', 
      creator: 'Charlie', 
      views: 320, 
      liked: false, 
      category: 'Plat principal',
      cookingSteps: [
        'Préparez la pâte à pizza.',
        'Étalez la pâte et ajoutez la sauce tomate.',
        'Parsemez de mozzarella et de basilic.',
        'Faites cuire au four à 220°C pendant 10-12 minutes.'
      ]
    },
    {
      name: 'Salade César', 
      image: 'assets/burger.jpg', 
      creator: 'David', 
      views: 120, 
      liked: false, 
      category: 'Entrée',
      cookingSteps: [
        'Lavez et coupez la laitue.',
        'Préparez la vinaigrette avec de la mayonnaise, de la moutarde et du vinaigre.',
        'Mélangez la salade, la vinaigrette et les croûtons.',
        'Ajoutez le parmesan râpé et les morceaux de poulet rôti.'
      ]
    },
    {
      name: 'Sushi saumon', 
      image: 'assets/burger.jpg', 
      creator: 'Emma', 
      views: 210, 
      liked: false, 
      category: 'Plat principal',
      cookingSteps: [
        'Cuire le riz à sushi.',
        'Préparez les feuilles de nori.',
        'Placez du riz et du saumon cru sur chaque feuille.',
        'Roulez le tout pour former un sushi.'
      ]
    },
    {
      name: 'Lasagnes maison', 
      image: 'assets/burger.jpg', 
      creator: 'Fay', 
      views: 170, 
      liked: false, 
      category: 'Plat principal',
      cookingSteps: [
        'Faites revenir de la viande hachée.',
        'Préparez une sauce béchamel.',
        'Alternez les couches de pâtes, de viande et de sauce dans un plat.',
        'Faites cuire au four à 180°C pendant 40 minutes.'
      ]
    },
    {
      name: 'Mousse au chocolat', 
      image: 'assets/burger.jpg', 
      creator: 'Gina', 
      views: 300, 
      liked: false, 
      category: 'Dessert',
      cookingSteps: [
        'Faites fondre le chocolat.',
        'Montez les blancs en neige.',
        'Mélangez délicatement le chocolat fondu avec les blancs en neige.',
        'Réfrigérez pendant au moins 2 heures.'
      ]
    },
    {
      name: 'Burger maison', 
      image: 'assets/burger.jpg', 
      creator: 'Hugo', 
      views: 150, 
      liked: false, 
      category: 'Plat principal',
      cookingSteps: [
        'Formez des steaks hachés.',
        'Faites cuire les steaks dans une poêle.',
        'Montez le burger avec du fromage, de la salade et de la sauce.',
        'Grillez le pain du burger.'
      ]
    },
    {
      name: 'Ratatouille', 
      image: 'assets/burger.jpg', 
      creator: 'Iris', 
      views: 220, 
      liked: false, 
      category: 'Plat principal',
      cookingSteps: [
        'Coupez les légumes en dés (courgette, aubergine, poivron, tomate).',
        'Faites revenir les légumes dans une poêle avec de l\'huile d\'olive.',
        'Ajoutez de l\'ail et des herbes de Provence.',
        'Laissez mijoter pendant 30 minutes.'
      ]
    },
    {
      name: 'Quiche lorraine', 
      image: 'assets/burger.jpg', 
      creator: 'Jack', 
      views: 110, 
      liked: false, 
      category: 'Plat principal',
      cookingSteps: [
        'Faites cuire une pâte brisée.',
        'Préparez l\'appareil à quiche avec des œufs, de la crème et du lait.',
        'Ajoutez des lardons et du fromage râpé.',
        'Versez l\'appareil sur la pâte et faites cuire au four à 180°C pendant 30 minutes.'
      ]
    },
    {
      name: 'Gaufres liégeoises', 
      image: 'assets/burger.jpg', 
      creator: 'Kara', 
      views: 190, 
      liked: false, 
      category: 'Dessert',
      cookingSteps: [
        'Préparez la pâte à gaufre avec de la levure, du beurre et du sucre.',
        'Laissez reposer la pâte pendant 30 minutes.',
        'Faites cuire dans un gaufrier.'
      ]
    },
    {
      name: 'Crêpes sucrées', 
      image: 'assets/burger.jpg', 
      creator: 'Leo', 
      views: 250, 
      liked: false, 
      category: 'Dessert',
      cookingSteps: [
        'Préparez la pâte à crêpes avec de la farine, des œufs, du lait et du sucre.',
        'Faites cuire les crêpes dans une poêle avec un peu de beurre.',
        'Servez avec du sucre, du Nutella ou des fruits.'
      ]
    }
  ];

  currentPage = 0;
  itemsPerPage = 8;
  selectedRecipe: any = null;
  isModalVisible = false; 


  openModal(recipe: any) {
    this.selectedRecipe = recipe;
    this.isModalVisible = true;
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