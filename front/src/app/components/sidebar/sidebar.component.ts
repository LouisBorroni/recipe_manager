import { Component, EventEmitter, Output } from '@angular/core';
import { RecipeCreationModalComponent } from '../recipe-creation-modal/recipe-creation-modal.component';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-sidebar',
  imports: [RecipeCreationModalComponent, CommonModule],
  templateUrl: './sidebar.component.html',
  styleUrl: './sidebar.component.scss'
})
export class SidebarComponent {
  @Output() sectionChange = new EventEmitter<string>();
  selectedButton: string = 'recipes'; 
  isModalVisible = false;
  

  selectButton(button: string): void {
    this.selectedButton = button;
    this.sectionChange.emit(button);
  }

  openModal(): void {
    this.isModalVisible = true;
  }

  closeModal(): void {
    this.isModalVisible = false;
  }

  handleRecipeCreated(): void {
    this.closeModal();
  }
}
