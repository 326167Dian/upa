import { DemoFormBasicValidationComponent } from './demos/basic-validation/basic-validation';
import { DemoFormCustomErrorMessageComponent } from './demos/custom-error-message/custom-error-message'
import { DemoFormGridComponent } from './demos/grid/grid';
import { DemoFormHorizontalComponent } from './demos/horizontal/horizontal'
import { DemoFormSizingComponent } from './demos/sizing/sizing';
import { DemoFormAutoComponent } from './demos/auto/auto';
import { DemoFormInlineComponent } from './demos/inline/inline';

import { ContentSection } from '@app/shared/components/docs/models/content-section.model';
import { DemoTopSectionComponent } from '@app/shared/components/docs/demo-section-components/demo-top-section/index';
import { ExamplesComponent } from '@app/shared/components/docs/demo-section-components/demo-examples-section/index';
import { ApiSectionsComponent } from '@app/shared/components/docs/demo-section-components/demo-api-section/index';

import {
  NgApiDocComponent
} from '@app/shared/components/docs/api-docs';

export const demoComponentContent: ContentSection[] = [
  {
    name: 'Usage',
    anchor: 'usage',
    outlet: DemoTopSectionComponent,
    content: {
      doc: require('!!raw-loader!./docs/usage.md')
    }
  },
  {
    name: 'Examples',
    anchor: 'examples',
    outlet: ExamplesComponent,
    content: [
      {
        title: 'Basic Validation',
        anchor: 'basic-validation',
        description: `<p>Basic form validation</p>`,
        component: require('!!raw-loader!./demos/basic-validation/basic-validation'),
        html: require('!!raw-loader!./demos/basic-validation/basic-validation.html'),
        outlet: DemoFormBasicValidationComponent
      },
      {
        title: 'Custom Error Message',
        anchor: 'custom-error-message',
        description: `<p>Validation with custom message</p>`,
        component: require('!!raw-loader!./demos/custom-error-message/custom-error-message'),
        html: require('!!raw-loader!./demos/custom-error-message/custom-error-message.html'),
        outlet: DemoFormCustomErrorMessageComponent
      },
      {
        title: 'Form Grid',
        anchor: 'form-grid',
        description: `<p>More complex forms can be built using bootstrap grid. Use these for form layouts that require multiple columns, varied widths, and additional alignment options.</p>`,
        component: require('!!raw-loader!./demos/grid/grid'),
        html: require('!!raw-loader!./demos/grid/grid.html'),
        outlet: DemoFormGridComponent
      },
      {
        title: 'Horizontal form',
        anchor: 'horizontal-form',
        description: `<p>Create horizontal forms with the grid by adding the <code>.row</code> class to form groups and using the <code>.col-*-*</code> classes to specify the width of your labels and controls.</p>`,
        component: require('!!raw-loader!./demos/horizontal/horizontal'),
        html: require('!!raw-loader!./demos/horizontal/horizontal.html'),
        outlet: DemoFormHorizontalComponent
      },
      {
        title: 'Horizontal form label sizing',
        anchor: 'horizontal-form-label-sizing',
        description: `<p>Be sure to use <code>.col-form-label-sm</code> or <code>.col-form-label-lg</code> to your <code>&lt;label&gt;</code>s or <code>&lt;legend&gt;</code>s to correctly follow the size of <code>.form-control-lg</code> and <code>.form-control-sm</code>.</p>`,
        component: require('!!raw-loader!./demos/sizing/sizing'),
        html: require('!!raw-loader!./demos/sizing/sizing.html'),
        outlet: DemoFormSizingComponent
      },
      {
        title: 'Auto-sizing',
        anchor: 'auto-sizing',
        description: `<p>The example below uses a flexbox utility to vertically center the contents and changes <code>.col</code> to <code>.col-auto</code> so that your columns only take up as much space as needed. Put another way, the column sizes itself based on the contents.</p>`,
        component: require('!!raw-loader!./demos/auto/auto'),
        html: require('!!raw-loader!./demos/auto/auto.html'),
        outlet: DemoFormAutoComponent
      },
      {
        title: 'Inline Form',
        anchor: 'inline-form',
        description: `<p>Use the <code>.col-auto</code> class to create horizontal layouts. By adding <a href="/docs/5.0/layout/gutters/">gutter modifier classes</a>, we’ll have gutters in horizontal and vertical directions. The <code>.align-items-center</code> aligns the form elements to the middle, making the <code>.form-checkbox</code> align properly.</p>`,
        component: require('!!raw-loader!./demos/inline/inline'),
        html: require('!!raw-loader!./demos/inline/inline.html'),
        outlet: DemoFormInlineComponent
      }
    ]
  }
];
