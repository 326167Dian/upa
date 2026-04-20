import { DemoCheckboxBasicComponent } from './demos/basic/basic';
import { DemoCheckBoxMultipleComponent } from './demos/multiple/multiple';
import { DemoCheckboxDisabaledComponent } from './demos/disabled/disabled';
import { DemoCheckboxInlineComponent } from './demos/inline/inline';
import { DemoCheckboxWithFormComponent } from './demos/withForm/withForm';

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
        title: 'Basic',
        anchor: 'basic',
        description: `<p>Basic usage</p>`,
        component: require('!!raw-loader!./demos/basic/basic'),
        html: require('!!raw-loader!./demos/basic/basic.html'),
        outlet: DemoCheckboxBasicComponent
      },
      {
        title: 'Multiple',
        anchor: 'multiple',
        description: `<p>Multiple checkbox </p>`,
        component: require('!!raw-loader!./demos/multiple/multiple'),
        html: require('!!raw-loader!./demos/multiple/multiple.html'),
        outlet: DemoCheckBoxMultipleComponent
      },
      {
        title: 'Disabled',
        anchor: 'disabled',
        description: `<p>Checkbox disabled</p>`,
        component: require('!!raw-loader!./demos/disabled/disabled'),
        html: require('!!raw-loader!./demos/disabled/disabled.html'),
        outlet: DemoCheckboxDisabaledComponent
      },
      {
        title: 'Inline',
        anchor: 'inline',
        description: `<p>Inline checkboxes</p>`,
        component: require('!!raw-loader!./demos/inline/inline'),
        html: require('!!raw-loader!./demos/inline/inline.html'),
        outlet: DemoCheckboxInlineComponent
      },
      {
        title: 'With Form',
        anchor: 'with-form',
        description: `<p>Usage with form</p>`,
        component: require('!!raw-loader!./demos/withForm/withForm'),
        html: require('!!raw-loader!./demos/withForm/withForm.html'),
        outlet: DemoCheckboxWithFormComponent
      },
    ]
  },
  {
    name: 'API Reference',
    anchor: 'api-reference',
    outlet: ApiSectionsComponent,
    content: [
      {
        title: 'CheckboxComponent',
        anchor: 'checkbox-component',
        outlet: NgApiDocComponent
      }
    ]
  }
];
