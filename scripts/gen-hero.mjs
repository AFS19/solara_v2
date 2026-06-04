import fs from 'fs';
import path from 'path';

const json = JSON.stringify({
  asset: { version: '2.0' },
  scene: 0,
  scenes: [{ nodes: [0] }],
  nodes: [{ mesh: 0 }],
  meshes: [{ primitives: [{ attributes: { POSITION: 0 }, mode: 4 }] }],
  accessors: [{ bufferView: 0, componentType: 5126, count: 3, type: 'VEC3', max: [1, 1, 0], min: [0, 0, 0] }],
  bufferViews: [{ buffer: 0, byteOffset: 0, byteLength: 36 }],
  buffers: [{ byteLength: 36 }],
});

const jsonBytes = Buffer.from(json);
const jsonPadding = (4 - (jsonBytes.length % 4)) % 4;
const jsonChunkLength = jsonBytes.length + jsonPadding;

const binData = Buffer.alloc(36);
// 3 floats per vertex, 3 vertices: (0,0,0), (1,0,0), (0,1,0)
binData.writeFloatLE(0, 0);  binData.writeFloatLE(0, 4);  binData.writeFloatLE(0, 8);
binData.writeFloatLE(1, 12); binData.writeFloatLE(0, 16); binData.writeFloatLE(0, 20);
binData.writeFloatLE(0, 24); binData.writeFloatLE(1, 28); binData.writeFloatLE(0, 32);
const binPadding = (4 - (binData.length % 4)) % 4;
const binChunkLength = binData.length + binPadding;

const totalLength = 12 + 8 + jsonChunkLength + 8 + binChunkLength;
const glb = Buffer.alloc(totalLength);
let off = 0;

// Header
glb.writeUInt32LE(0x46546C67, off); off += 4; // magic 'glTF'
glb.writeUInt32LE(2, off); off += 4;         // version
glb.writeUInt32LE(totalLength, off); off += 4;

// JSON chunk
glb.writeUInt32LE(jsonChunkLength, off); off += 4;
glb.writeUInt32LE(0x4E4F534A, off); off += 4; // chunkType 'JSON'
jsonBytes.copy(glb, off); off += jsonBytes.length;
for (let i = 0; i < jsonPadding; i++) glb.writeUInt8(0x20, off++); // space padding

// BIN chunk
glb.writeUInt32LE(binChunkLength, off); off += 4;
glb.writeUInt32LE(0x004E4942, off); off += 4; // chunkType 'BIN'
binData.copy(glb, off); off += binData.length;
for (let i = 0; i < binPadding; i++) glb.writeUInt8(0, off++);

const out = path.resolve('storage/app/public/models/hero.glb');
fs.mkdirSync(path.dirname(out), { recursive: true });
fs.writeFileSync(out, glb);
console.log('Wrote', out, glb.length, 'bytes');
