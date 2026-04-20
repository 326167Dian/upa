import { NgModule } from '@angular/core';
import { SharedModule } from '@app/shared/shared.module';
import { RouterModule } from '@angular/router';
import { InputSectionComponent } from './input-section.component';
import { DEMO_COMPONENTS } from './demos';
import { DocsModule } from '@app/shared/components/docs';
import { DropdownModule } from '@app/shared/components/dropdown/dropdown.module';

import { routes } from './demo-input.routes';

@NgModule({
  declarations: [
    InputSectionComponent,
    ...DEMO_COMPONENTS
  ],
  imports: [
    SharedModule,
    DropdownModule,
    DocsModule,
    RouterModule.forChild(routes)
  ],
  exports: [InputSectionComponent],
  entryComponents: [...DEMO_COMPONENTS]
})
export class DemoInputModule {
  static routes: any = routes;
}
