const fs = require('fs');
const path = require('path');
const fontkit = require('fontkit');

const directories = ['css', 'fonts', 'js', 'vendor'];

function generateDocumentation(filePath) {
    const ext = path.extname(filePath);
    let documentation = `# Documentation for ${filePath}\n\n`;

    const content = fs.readFileSync(filePath, 'utf8');

    switch (ext) {
        case '.css':
            documentation += generateCssDocumentation(content);
            break;
        case '.js':
            documentation += generateJsDocumentation(content);
            break;
        case '.ttf':
        case '.otf':
        case '.woff':
        case '.woff2':
            documentation += generateFontDocumentation(filePath);
            break;
        default:
            documentation += 'Documentation for this file type is not supported yet.\n';
    }

    return documentation;
}

function generateCssDocumentation(content) {
    let documentation = '## CSS File\n\n';

    const lines = content.split('\n');
    lines.forEach((line, index) => {
        if (line.trim().startsWith('/*') && line.trim().endsWith('*/')) {
            documentation += `### Comment at line ${index + 1}\n${line.trim()}\n\n`;
        } else if (line.includes('{')) {
            const selector = line.split('{')[0].trim();
            documentation += `### Selector: \`${selector}\`\n`;
        } else if (line.includes(':') && line.includes(';')) {
            const [property, value] = line.split(':');
            documentation += `- **${property.trim()}**: ${value.split(';')[0].trim()}\n`;
        } else if (line.includes('@media')) {
            documentation += `### Media Query: \`${line.trim()}\`\n`;
        } else if (line.includes('@keyframes')) {
            documentation += `### Animation: \`${line.trim()}\`\n`;
        }
    });

    return documentation;
}

function generateJsDocumentation(content) {
    let documentation = '## JavaScript File\n\n';
    const lines = content.split('\n');

    lines.forEach((line, index) => {
        if (line.trim().startsWith('/**') || line.trim().startsWith('/*')) {
            documentation += `### Comment at line ${index + 1}\n${line.trim()}\n\n`;
        } else if (line.trim().startsWith('function')) {
            const functionName = line.split(' ')[1].split('(')[0];
            documentation += `### Function: \`${functionName}\`\n`;
        } else if (line.trim().startsWith('class')) {
            const className = line.split(' ')[1];
            documentation += `### Class: \`${className}\`\n`;
        } else if (line.includes('const') || line.includes('let') || line.includes('var')) {
            const variableName = line.split(' ')[1];
            documentation += `- Variable: \`${variableName}\`\n`;
        }
    });

    return documentation;
}

function generateFontDocumentation(filePath) {
    let documentation = `## Font File\n\nDetails about the font file ${path.basename(filePath)}.\n\n`;
    try {
        const font = fontkit.openSync(filePath);
        documentation += `- **Font Family**: ${font.familyName}\n`;
        documentation += `- **Font Subfamily**: ${font.subfamilyName}\n`;
        documentation += `- **Postscript Name**: ${font.postscriptName}\n`;
        documentation += `- **Full Name**: ${font.fullName}\n`;
    } catch (error) {
        documentation += 'Error extracting font metadata.\n';
    }
    return documentation;
}

function processDirectory(directory) {
    fs.readdir(directory, (err, files) => {
        if (err) {
            console.error(`Could not list the directory ${directory}:`, err);
            return;
        }

        files.forEach((file, index) => {
            const filePath = path.join(directory, file);

            fs.stat(filePath, (error, stat) => {
                if (error) {
                    console.error(`Error stating file ${filePath}:`, error);
                    return;
                }

                if (stat.isFile()) {
                    const documentation = generateDocumentation(filePath);
                    const docPath = `${filePath}.md`;
                    fs.writeFileSync(docPath, documentation, 'utf8');
                    console.log(`Documentation generated for ${filePath} at ${docPath}`);
                } else if (stat.isDirectory()) {
                    processDirectory(filePath);
                }
            });
        });
    });
}

directories.forEach(directory => processDirectory(directory));
