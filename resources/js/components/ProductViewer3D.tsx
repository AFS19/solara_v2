import { Canvas } from '@react-three/fiber';
import { useGLTF, OrbitControls } from '@react-three/drei';
import { Suspense } from 'react';

function Model({ url }: { url: string }) {
  const { scene } = useGLTF(url);
  return <primitive object={scene} scale={1.2} rotation={[0, Math.PI / 4, 0]} />;
}

export default function ProductViewer3D({ url, className }: { url: string; className?: string }) {
  return (
    <div className={className}>
      <Canvas shadows camera={{ position: [0, 0, 3.5], fov: 45 }}>
        <ambientLight intensity={0.5} />
        <directionalLight position={[2, 3, 2]} intensity={1.5} />
        <Suspense fallback={null}>
          <Model url={url} />
        </Suspense>
        <OrbitControls enableZoom enablePan={false} />
      </Canvas>
    </div>
  );
}
