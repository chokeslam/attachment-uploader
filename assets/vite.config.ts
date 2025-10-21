import vuePlugin from '@vitejs/plugin-vue';
import { resolve } from 'node:path';
import dts from 'unplugin-dts/vite';
import { defineConfig } from 'vite';
import fs from 'fs-extra';

export default defineConfig(({ mode }) => {

  return {
    base: './',
    resolve: {
      alias: {
        '~attachment': resolve('./src'),
      },
      dedupe: ['vue']
    },
    build: {
      lib: {
        entry: [
          'src/index.ts',
        ],
        name: 'Attachment',
        formats: ['es'],
      },
      rollupOptions: {
        // preserveEntrySignatures: 'strict',
        // input: [
        //   'src/index.ts',
        //   ...fs.globSync('src/fields/*.ts')
        // ],
        output: {
          format: 'es',
          entryFileNames: '[name].js',
          chunkFileNames(chunkInfo) {
            return 'chunks/[name].js';
          },
          assetFileNames: (info) => {
            console.log(info);
            if (info.originalFileNames[0] === 'style.css') {
              return 'attachment-edit.css';
            }

            return 'assets/[name][extname]';
          },
        },
        external: [
          '@windwalker-io/unicorn-next',
          'sortablejs',
        ]
      },
      outDir: 'dist',
      emptyOutDir: true,
      sourcemap: 'external',
      minify: false,
      cssCodeSplit: false,
    },
    plugins: [
      dts({
        insertTypesEntry: true,
        outDir: 'dist',
        tsconfigPath: resolve('./tsconfig.json'),
        bundleTypes: true,
      }),
      {
        name: 'clear-files',
        generateBundle() {
          // rimraf.sync('./dist/**/*.js', { glob: true });
        }
      }
    ]
  };
});
