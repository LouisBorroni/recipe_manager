import { Recipe } from "./recipe.model";

export interface User {
    username: string;
    roles: string[];
    recipes: Recipe[];
  }