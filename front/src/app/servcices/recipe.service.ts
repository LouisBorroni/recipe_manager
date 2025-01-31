import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Store } from '@ngrx/store';

@Injectable({
  providedIn: 'root',
})
export class RecipeService {
  private baseUrl = 'http://localhost:8000/api';

  constructor(private router: Router, private store: Store) {}

  logRecipeCreation(recipe: any): void {
    console.log('Nouvelle recette ajoutée :', recipe);
  }
}
